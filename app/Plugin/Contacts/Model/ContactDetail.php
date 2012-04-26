<?php
class ContactDetail extends ContactsAppModel {
	var $name = 'ContactDetail';
	var $displayField = 'value';
	var $validate = array(
		'value' => array(
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

	var $belongsTo = array(
		'Contact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function types() {
		$types = array();
		foreach(Zuha::enum('CONTACT_DETAIL') as $type) {
			$types[Inflector::underscore($type)] = $type;
		}
		return array_merge(array('email' => 'Email'), $types);
	}
}