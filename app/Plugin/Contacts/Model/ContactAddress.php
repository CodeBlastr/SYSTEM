<?php
class ContactAddress extends ContactsAppModel {
	var $name = 'ContactAddress';
	var $displayField = 'street1';
	var $validate = array();
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'ContactAddressType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'contact_address_type_id',
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
		)
	);
}
?>