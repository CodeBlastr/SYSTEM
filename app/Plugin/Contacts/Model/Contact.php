<?php

App::uses('ContactsAppModel', 'Contacts.Model');

class Contact extends ContactsAppModel {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Contact';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Notify Assign
 *
 * @var bool
 */
	public $notifyAssignee = false;
	

/**
 * Validate
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Contact requires a name.',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * Belongs to
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Assignee' => array(
			'className' => 'Users.User',
			'foreignKey' => 'assignee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);


/**
 * Has many
 *
 * @var array
 */
	public $hasMany = array(
		'ContactAddress' => array(
			'className' => 'Contacts.ContactAddress',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContactDetail' => array(
			'className' => 'Contacts.ContactDetail',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);


/**
 * Has and belongs to many
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Employer' => array(
			'className' => 'Contacts.Contact',
			'joinTable' => 'contacts_contacts',
			'foreignKey' => 'child_contact_id',
			'associationForeignKey' => 'parent_contact_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Employee' => array(
			'className' => 'Contacts.Contact',
			'joinTable' => 'contacts_contacts',
			'foreignKey' => 'parent_contact_id',
			'associationForeignKey' => 'child_contact_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
	);


/**
 * Construct
 *
 * @return null
 */
	public function __construct($id = false, $table = null, $ds = null) {

		if (in_array('Tasks', CakePlugin::loaded())) {
			$this->hasMany['Task'] = array(
				'className' => 'Tasks.Task',
				'foreignKey' => 'foreign_key',
				'dependent' => true,
				'conditions' => array('Task.model' => 'Contact'),
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			);
		}
		if (in_array('Activities', CakePlugin::loaded())) {
			$this->hasMany['Activity'] = array(
				'className' => 'Activities.Activity',
				'foreignKey' => 'foreign_key',
				'dependent' => true,
				'conditions' => array('Activity.model' => 'Contact'),
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			);
		}
		if (in_array('Estimates', CakePlugin::loaded())) {
			$this->hasMany['Estimate'] = array(
				'className' => 'Estimates.Estimate',
				'foreignKey' => 'foreign_key',
				'dependent' => true,
				'conditions' => array('Estimate.model' => 'Contact'),
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			);
		}
    	parent::__construct($id, $table, $ds);
		$this->order = array("{$this->alias}.name");
    }
	
	
	public function beforeSave($options = array()) {
		!empty($this->data['Contact']['contact_type']) ? $this->data['Contact']['contact_type'] = strtolower($this->data['Contact']['contact_type']) : null; 
		if (in_array('Activities', CakePlugin::loaded()) && !empty($this->data['Contact']['contact_type']) && $this->data['Contact']['contact_type'] == 'lead') {
			// log when leads are created
			$this->Behaviors->attach('Activities.Loggable', array(
				'nameField' => 'name', 
				'descriptionField' => '',
				'actionDescription' => 'lead created', 
				'userField' => '', 
				'parentForeignKey' => ''
				));
		}
		$this->checkAssigneeChange();
		return parent::beforeSave($options);
	}
	
	public function afterSave($created) {
		$this->notifyAssignee();
		return parent::afterSave($created);
	}
 

/**
 * Add method
 *
 * @return bool
 */
	public function add($data) {
		$data = $this->_cleanContactData($data);
		if ($this->saveAll($data)) {
			return __d('contacts', 'Contact saved successfully.');
		} else {
			$error = 'Error : ';
			foreach ($this->invalidFields() as $models) {
				if (is_array($models)) {
					foreach ($models as $err) {
						if(is_string($err)) $error .= $err . ', ';
						if(is_array($err)) {
                          foreach($err as $er)
                          $error .= $er . ', ';
                        }
					}
				} else {
					$error .= $models;
				}
			}
			throw new Exception($error);
		}
	}

/**
 * Find companies
 *
 * @return array
 */
	public function findCompanies($type = 'list', $params = null) {
		$params['conditions'] = array(
			"{$this->alias}.is_company" => 1,
			);
		$params['order'] = empty($params['order']) ? "{$this->alias}.name" : $params['order'];

		return $this->find($type, $params);
	}

/**
 * Find people
 *
 * @return array
 */
	public function findPeople($type = 'list', $params = null) {
		$params['conditions'] = array(
			"{$this->alias}.is_company" => 0,
			);
		$params['order'] = empty($params['order']) ? "{$this->alias}.name" : $params['order'];

		return $this->find($type, $params);
	}

/**
 * Find companies with registered users
 *
 * @return array
 */
	public function findCompaniesWithRegisteredUsers($type = 'list', $params = null) {
		// first find registered people
		$people = $this->find('list', array(
			'conditions' => array(
				'Contact.user_id is NOT NULL',
				'Contact.is_company' => 0,
				),
			));
		// I could contain Relator here, but I want to preserve the $type attributes
		// so we do an extra query to get the companies.
		$companies = $this->ContactsContact->find('all', array(
			'conditions' => array(
				'ContactsContact.child_contact_id' => array_flip($people),
				),
			));

		$companies = Set::extract('/ContactsContact/parent_contact_id', $companies);
		$params['conditions']['Contact.id'] = $companies;

		return $this->find($type, $params);
	}


/**
 * Clean data for saving
 *
 * @return array
 */
	protected function _cleanContactData($data) {
		// get rid of the name field so it can be merged from existing data if empty
		if (isset($data['Contact']['name']) && empty($data['Contact']['name'])) {
			unset($data['Contact']['name']); 
		}
		
		// if id is here, then merge the data with the existing data (new data over writes old)
		if (!empty($data['Contact']['id'])) {
			$contact = $this->find('first', array(
				'conditions' => array(
					'Contact.id' => $data['Contact']['id'],
					),
				'contain' => array(
					'User',
					'Employer',
					),
				));
			$data = Set::merge($contact, $data);
			unset($data['Contact']['modified']);
		} else if (!empty($data['User']['id']) && empty($data['Contact']['user_id'])) {
			// this id should only be checked if contact id isn't there because if id is there user is found above
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.id' => $data['User']['id']
					),
				'fields' => array(
					'User.id'
					)
				));
			$data['Contact']['user_id'] = !empty($user) ? $data['User']['id'] : null;
			// unset User because we can't run callbacks using saveAll (so validation fails for user)
			unset($data['User']);
		}
		
		// belongsTo records return null values when there is nothing to contain (guest checkout gives you some data with no id)
		if (empty($data['User']['id']) && empty($data['User']['email'])) {
			unset($data['User']);
		}

		// if employer is not empty merge all employers so that we don't lose any existing employers in the Habtm update
		if (!empty($data['Employer'])) {
			$mergedEmployers = Set::merge(Set::extract('/id', $data['Employer']), $data['Employer']['Employer']);
			unset($data['Employer']);
			$data['Employer']['Employer'] = $mergedEmployers;
		}

		if (!empty($data['User'])){
			foreach ($data['User'] as $key => $userData) {
				if (is_array($userData)) {
					$data['User'][$key] = implode(',', $userData);
				}
			}
		}

		//add contact name if its empty
		if (empty($data['Contact']['name'])) {
			$data['Contact']['name'] = !empty($data['User']['full_name']) ? $data['User']['full_name'] : $data['User']['username'];
			$data['Contact']['name'] = !empty($data['Contact']['name']) ? $data['Contact']['name'] : 'Unknown';
		}

		// remove empty contact detail values, because the form sets the array which makes a save attempt
		if (!empty($data['ContactDetail'])) {
			$i = 0;
			$data['ContactDetail'] = array_values($data['ContactDetail']);			
			foreach ($data['ContactDetail'] as $detail) {
				if (empty($detail['value'])) {
					unset($data['ContactDetail'][$i]);
				}
				$i++;
			}
		}

		// remove empty related models
		if (!empty($data['Estimate'])) {
			$i = 0;
			$data['Estimate'] = array_values($data['Estimate']);			
			foreach ($data['Estimate'] as $estimate) {
				if (empty($estimate['total'])) {
					unset($data['Estimate'][$i]);
				}
				$i++;
			}
		}

		// remove empty related models
		if (!empty($data['Activity'])) {
			$i = 0;
			$data['Activity'] = array_values($data['Activity']);			
			foreach ($data['Activity'] as $activity) {
				if (empty($activity['name'])) {
					unset($data['Activity'][$i]);
				}
				$i++;
			}
		}

		// remove empty related models
		if (!empty($data['Task'])) {
			$i = 0;
			$data['Task'] = array_values($data['Task']);			
			foreach ($data['Task'] as $task) {
				if (empty($task['name'])) {
					unset($data['Task'][$i]);
				}
				$i++;
			}
		}
		
		return $data;
	}

/**
 * Types of contacts
 *
 * @return array
 */
    public function types() {
        $types = array();
        foreach (Zuha::enum('CONTACT_TYPE') as $type) {
            $types[Inflector::underscore($type)] = $type;
        }
        return array_merge(array('lead' => 'Lead', 'customer' => 'Customer'), $types);
    }


/**
 * Sources for contacts
 *
 * @return array
 */
    public function sources() {
        $sources = array();
        foreach (Zuha::enum('CONTACT_SOURCE') as $source) {
            $sources[Inflector::underscore($source)] = $source;
        }
        return $sources;
    }


/**
 * Industries for contacts
 *
 * @return array
 */
    public function industries() {
        $industries = array();
        foreach (Zuha::enum('CONTACT_INDUSTRY') as $industry) {
            $industries[Inflector::underscore($industry)] = $industry;
        }
        return $industries;
    }


/**
 * Ratings for contacts
 *
 * @return array
 */
    public function ratings() {
        $ratings = array();
        foreach (Zuha::enum('CONTACT_RATING') as $rating) {
            $ratings[Inflector::underscore($rating)] = $rating;
        }
        return array_merge(array('hot' => 'Hot', 'warm' => 'Warm', 'cold' => 'Cold'), $ratings);
    }

/**
 * A temporary function to fix db values
 * 10/30/2012 Rk
 */
 	public function fixTypes() { 
		$result = $this->query("SELECT COUNT(*) AS `count` FROM `contacts` AS `Contact` WHERE `Contact`.`contact_type` LIKE BINARY 'Lead';");
		if ($result[0][0]['count']) {
			$this->query("UPDATE `contacts` SET `contacts`.`contact_type` = 'lead' WHERE `contacts`.`contact_type` = 'Lead';");
			$this->query("UPDATE `contacts` SET `contacts`.`contact_type` = 'customer' WHERE `contacts`.`contact_type` = 'Customer';");
			$this->query("UPDATE `contacts` SET `contacts`.`contact_rating` = 'active' WHERE `contacts`.`contact_rating` = 'Active';");
			$this->query("UPDATE `contacts` SET `contacts`.`contact_rating` = 'hot' WHERE `contacts`.`contact_rating` = 'Hot';");
			$this->query("UPDATE `contacts` SET `contacts`.`contact_rating` = 'warm' WHERE `contacts`.`contact_rating` = 'Warm';");
			$this->query("UPDATE `contacts` SET `contacts`.`contact_rating` = 'cold' WHERE `contacts`.`contact_rating` = 'Cold';");
		}
	}
	
/**
 * Get leads
 *
 * @return array
 */
 	public function leads() {
		return $this->find('all', array(
			'conditions' => array(
				'Contact.contact_type' => 'lead',
				'Contact.assignee_id' => null, 
				),
			'limit' => 5,
			'order' => array(
				'Contact.created' => 'DESC',
				),
			));
	}
	
/**
 * Get leads logged over time
 *
 * @return array
 */
 	public function leadActivities() {
		$return = null;
		if (in_array('Activities', CakePlugin::loaded())) {
			$return = $this->Activity->find('all', array(
				'conditions' => array(
					'Activity.action_description' => 'lead created',
					'Activity.model' => 'Contact',
					),
				'fields' => array(
					'COUNT(Activity.created)',
					'Activity.created',
					),
				'group' =>  array(
					'DATE(Activity.created)',
					),
				'order' => array(
					'Activity.created' => 'ASC',
					)
				));
		}
		return $return;
	}
	
/**
 * Get tasks assigned to the current user, and are related to contacts
 *
 * @return array
 */
 	public function myTasks() {
		$return = null;
		if (in_array('Tasks', CakePlugin::loaded())) {
			$return = $this->Task->find('all', array(
				'conditions' => array(
					'Task.assignee_id' => CakeSession::read('Auth.User.id'),
					'Task.model' => 'Contact',
					'Task.is_completed' => false,
					),
				'order' => array(
					'Task.due_date' => 'ASC',
					)
				));
		}
		return $return;
	}
	
/**
 * Estimates method
 *
 * @return array
 */
	public function estimates($foreignKey = null) {
		$return = null;
		if (in_array('Estimates', CakePlugin::loaded())) {
			$conditions['Estimate.is_accepted'] = 0;
			$conditions['Estimate.is_archived'] = 0;
			$conditions['Estimate.model'] = 'Contact';
			!empty($foreignKey) ? $conditions['Estimate.foreign_key'] = $foreignKey : null; 
			$return = $this->Estimate->find('all', array(
				'conditions' => $conditions,
				'contain' => array(
					'Contact'
					)
				));
			$converted = $this->Estimate->find('count', array(
				'conditions' => array(
					'Estimate.is_accepted' => 1,
					'Estimate.model' => 'Contact',
					)
				));
			$dead = $this->Estimate->find('count', array(
				'conditions' => array(
					'Estimate.is_accepted' => 0,
					'Estimate.is_archived' => 1,
					'Estimate.model' => 'Contact',
					)
				));
			
			$ratings['hot'] = 85;
			$ratings['warm'] = 30;
			$ratings['cold'] = 10;
			$values = Set::combine($return, '{n}.Estimate.id', '{n}.Contact.contact_rating');
			foreach ($values as $value) {
				$average[] = !empty($ratings[$value]) ? $ratings[$value] : 0;
			}
			$return['_subTotal'] = ZuhaInflector::pricify(array_sum(Set::extract('/Estimate/total', $return)));
			$return['_multiplier'] = !empty($average) ? array_sum($average) / count($values) : 0;
			$return['_total'] = ZuhaInflector::pricify(array_sum(Set::extract('/Estimate/total', $return)) * ('.' . $return['_multiplier']));
			$return['_conversion'] = intval(($converted / (count($return) + $converted + $dead)) * 100);
		}
		
		return $return;
	}
	
/**
 * Estimate Groups method
 *
 * @return array
 */
	public function estimateActivities($foreignKey = null) {
		$return = null;
		if (in_array('Activities', CakePlugin::loaded())) {
			$return = $this->Activity->find('all', array(
				'conditions' => array(
					'Activity.action_description' => 'estimate created',
					'Activity.model' => 'Estimate',
					),
				'fields' => array(
					'COUNT(Activity.created)',
					'Activity.created',
					),
				'group' =>  array(
					'DATE(Activity.created)',
					),
				'order' => array(
					'Activity.created' => 'ASC',
					)
				));
		}
		
		return $return;
	}
	
/**
 * Activities method
 * 
 * Returns the last 60 days of activity.
 *
 * @return array
 */
	public function activities($conditions = array()) {
		$return = null;
		if (in_array('Activities', CakePlugin::loaded())) {
			/*$conditions['Activity.action_description'] = 'contact activity';
			$conditions['Activity.model'] = 'Contact';
			!empty($foreignKey) ? $conditions['Activity.foreign_key'] = $foreignKey : null;
			$return = $this->Activity->find('all', array(
				'conditions' => $conditions,
				'fields' => array(
					'*',
					"COUNT(Activity.created) AS count", // only one of these two will work
					"DATE_FORMAT(Activity.created, '%Y-%m-%d') AS created", // only one of these two will work
					),
				'group' =>  array(
					'DATE(Activity.created)',
					),
				'order' => array(
					'Activity.created' => 'ASC',
					)
				));*/  // might try to fix the Model::_filterResults() function at some point and submit it back to CakePHP devs.
				
			!empty($conditions['foreign_key']) ? $foreignKeyQuery = "AND `Activity`.`foreign_key` = '". $conditions['foreign_key'] . "'" : $foreignKeyQuery = null;
			$startDate = !empty($conditions['start_date']) ? $conditions['start_date'] : date('Y-m-d', strtotime('- 60 days'));
			$result = $this->query("SELECT *, DATE_FORMAT(Activity.created, '%Y-%m-%d') AS formatted, COUNT(`Activity`.`created`) AS count FROM `activities` AS `Activity` WHERE `Activity`.`created` > '".$startDate."' AND `Activity`.`action_description` = 'contact activity' AND `Activity`.`model` = 'Contact' ".$foreignKeyQuery." GROUP BY DATE(`Activity`.`created`) ORDER BY `Activity`.`created` ASC");
			$emptyDates = Zuha::date_slice($startDate, null, array('format' => 'Y-m-d'));
			foreach ($emptyDates as $emptyDate) {
				$key = array_search($emptyDate, Set::extract('/0/formatted', $result));
				if ($key === 0 || $key > 0) {
					$return[] = $result[$key];
				} else {
					$return[] = array(0 => array('count' => 0), 'Activity' => array('created' => $emptyDate));
				}
			}
		
		}
		return $return;
	}
	

/**
 * Check Assignee Change Method
 * 
 * @param
 * @return void
 */
 	public function checkAssigneeChange() {
		if (!empty($this->data['Contact']['assignee_id'])) {
			if (!empty($this->data['Contact']['id'])) {
				// check to see if assignee has been updated
				$result = $this->find('count', array(
					'conditions' => array(
						'Contact.id' => $this->data['Contact']['id'],
						'Contact.assignee_id' => $this->data['Contact']['assignee_id']
						)
					));
				if (empty($result)) {
					// assignee has changed
					$this->notifyAssignee = true;
				}
			} else {
				// if the contact id is empty this is a new record
				$this->notifyAssignee = true;
			}
		}
 	}
 
/**
 * Notify Assignee Method
 * sends an email to the assignee
 * 
 * @return void
 */
 	public function notifyAssignee() {
		if (!empty($this->data['Contact']['assignee_id']) && !empty($this->notifyAssignee)) {
			$this->Assignee->id = $this->data['Contact']['assignee_id'];
			$assignee = $this->Assignee->read();
			$recipient = $assignee['Assignee']['email'];
			$subject = 'New Assignment : ' . $this->data['Contact']['name'];
			$message = 'Congratulations, you have received a new business opportunity.  <br /><br /> View ' . $this->data['Contact']['contact_type'] . ' <a href="http://' . $_SERVER['HTTP_HOST'] . '/contacts/contacts/view/' . $this->data['Contact']['id'] .'">' . $this->data['Contact']['name'] .'</a> here.  Where you can track activity, change the status, create an estimate, or set a reminder to follow up.'; 
			if ($this->__sendMail($recipient, $subject, $message)) {
				return true;
			} else {
				throw Exception(__('Assignee could not be notified.'));
			}
		}
 	}
	

/**
 * origin_afterFind callback
 * 
 * A callback from related plugins which are only related by the abstract model/foreign_key in the db
 * 
 * @param array $results
 */
    public function origin_afterFind(Model $Model, $results = array(), $primary = false) {
    	if ($Model->name == 'Task') {
	        $ids = Set::extract('/Task/foreign_key', $results);
	        $contacts = $this->find('all', array('conditions' => array('Contact.id' => $ids)));
	        $names = Set::combine($contacts, '{n}.Contact.id', '{n}.Contact.name');
	        $i = 0;
	        foreach ($results as $result) {
	            if ($names[$result['Task']['foreign_key']]) {
	                $results[$i]['Task']['name'] = !strpos($results[$i]['Task']['name'], $names[$result['Task']['foreign_key']]) ? __('%s %s', $results[$i]['Task']['name'], $names[$result['Task']['foreign_key']]) : $results[$i]['Task']['name'];
	                $results[$i]['Task']['_associated']['name'] = $names[$result['Task']['foreign_key']];
	                $results[$i]['Task']['_associated']['viewLink'] = __('/contacts/contacts/view/%s', $result['Task']['foreign_key']);
	            }
				$i++;
	        }
	        return $results;
    	}
    	if ($Model->name == 'Estimate') {
	        $ids = Set::extract('/Estimate/foreign_key', $results);
	        $contacts = $this->find('all', array('conditions' => array('Contact.id' => $ids)));
	        $names = Set::combine($contacts, '{n}.Contact.id', '{n}.Contact.name');
	        $i = 0;
	        foreach ($results as $result) {
	            if ($names[$result['Estimate']['foreign_key']]) {
	                $results[$i]['Estimate']['name'] = !strpos($results[$i]['Estimate']['name'], $names[$result['Estimate']['foreign_key']]) ? __('%s %s', $results[$i]['Estimate']['name'], $names[$result['Estimate']['foreign_key']]) : $results[$i]['Estimate']['name'];
	                $results[$i]['Estimate']['_associated']['name'] = $names[$result['Estimate']['foreign_key']];
	                $results[$i]['Estimate']['_associated']['viewLink'] = __('/contacts/contacts/view/%s', $result['Estimate']['foreign_key']);
	            }
				$i++;
	        }
	        return $results;
    	}
    }

}