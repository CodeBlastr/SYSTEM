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
}
