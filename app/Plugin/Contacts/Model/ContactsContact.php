<?php
class ContactsContact extends ContactsAppModel {
	var $name = 'ContactsContact';
	var $validate = array(
		'parent_contact_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'child_contact_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/** 
	 * Instead of using a contact relationship type, we will use model names, like Company, Employee, Owner, and so on, as needed.  
	 */ 
	var $belongsTo = array(
		'ParentContact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'parent_contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ChildContact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'child_contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
