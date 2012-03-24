<?php
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
		'ContactType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'contact_type_id',
			'conditions' => array('ContactType.type' => 'CONTACTTYPE'),
			'fields' => '',
			'order' => ''
		),
		'ContactSource' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'contact_source_id',
			'conditions' => array('ContactSource.type' => 'CONTACTSOURCE'),
			'fields' => '',
			'order' => ''
		),
		'ContactIndustry' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'contact_industry_id',
			'conditions' => array('ContactIndustry.type' => 'CONTACTINDUSTRY'),
			'fields' => '',
			'order' => ''
		),
		'ContactRating' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'contact_rating_id',
			'conditions' => array('ContactRating.type' => 'CONTACTRATING'),
			'fields' => '',
			'order' => ''
		),
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
						$error .= $err . ', ';
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
		# I could contain Relator here, but I want to preserve the $type attributes
		# so we do an extra query to get the companies.
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
	private function _cleanContactData($data) {
		# if id is here, then merge the data with the existing data (new data over writes old)
		if (!empty($data['Contact']['id'])) :
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
		endif;
		
		# if employer is not empty merge all employers so that we don't lose any existing employers in the Habtm update
		if (!empty($data['Employer'])) :
			$mergedEmployers = Set::merge(Set::extract('/id', $data['Employer']), $data['Employer']['Employer']);
			unset($data['Employer']);
			$data['Employer']['Employer'] = $mergedEmployers;
		endif;
				
		foreach ($data['User'] as $key => $userData) :
			if (is_array($userData)) :
				$data['User'][$key] = implode(',', $userData);
			endif;
		endforeach;
		
		//add contact name if its empty
		if (empty($data['Contact']['name'])) :
			$data['Contact']['name'] = !empty($data['User']['full_name']) ? $data['User']['full_name'] : $data['User']['username'];
			$data['Contact']['name'] = !empty($data['Contact']['name']) ? $data['Contact']['name'] : 'Unknown';
		endif;
		
		
		// remove empty contact detail values, because the form sets the array which makes a save attempt
		if (!empty($data['ContactDetail'][0])) {
			$i = 0;
			foreach ($data['ContactDetail'] as $detail) {
				if (empty($detail['value'])) {
					unset($data['ContactDetail'][$i]);
				}
				$i++;
			}
		}
		// remove empty contact activity values, because the form sets the array which makes a save attempt
		if (!empty($data['ContactActivity'][0])) {
			$i = 0;
			foreach ($data['ContactActivity'] as $detail) {
				if (empty($detail['name'])) {
					unset($data['ContactActivity'][$i]);
				}
				$i++;
			}
		}
		
		return $data;
	}

}
?>