<?php
class ContactAddress extends ContactsAppModel {
	public $name = 'ContactAddress';
	public $displayField = 'street1';
	public $validate = array();
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $belongsTo = array(
		'ContactAddressType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'contact_address_type',
			'conditions' => array('ContactAddressType.type' => 'CONTACTADDRESS'),
			'fields' => '',
			'order' => ''
		),
		'Contact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User'
	);
	
	public function afterFind($results, $options = array()) {
		$results = $this->cleanOutput($results);
		return parent::afterFind($results, $options);
	}

/**
 * Clean Output method
 * 
 * @param array $data
 */
 	public function cleanOutput($data) {
 		for ($i = 0; $i < count($data); ++$i) {
 			if (empty($data[$i][$this->alias]['street1'])) {
 				$data[$i][$this->alias]['street1'] = '(n/a street)';
 			}
 			if (empty($data[$i][$this->alias]['street2'])) {
 				$data[$i][$this->alias]['street2'] = '(n/a street2)';
 			}
 			if (empty($data[$i][$this->alias]['city'])) {
 				$data[$i][$this->alias]['city'] = '(n/a city)';
 			}
 			if (empty($data[$i][$this->alias]['state'])) {
 				$data[$i][$this->alias]['state'] = '(n/a state)';
 			}
 			if (empty($data[$i][$this->alias]['zip_postal'])) {
 				$data[$i][$this->alias]['zip_postal'] = '(n/a zip)';
 			}
 			if (empty($data[$i][$this->alias]['country'])) {
 				$data[$i][$this->alias]['country'] = '(n/a country)';
 			}
 		}
		return $data;
 	}
}
