<?php
class ContactsTag extends AppModel {

	var $name = 'ContactsTag';
	var $validate = array(
		'tag_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>