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
    	parent::__construct($id, $table, $ds);
		$this->order = array("{$this->alias}.name");

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
    }
	
	
	function beforeSave() {
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
		return true;
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
		#first find registered people
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
        return array_merge(array('active' => 'Active', 'hot' => 'Hot', 'warm' => 'Warm', 'cold' => 'Cold'), $ratings);
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


}