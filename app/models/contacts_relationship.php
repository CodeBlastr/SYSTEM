<?php
class ContactsRelationship extends AppModel {

	var $name = 'ContactsRelationship';
	var $validate = array(
		'contact_relationship_type_id' => array('numeric'),
		'contact_id' => array('numeric'),
		'related_contact_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ContactRelationshipType' => array(
			'className' => 'ContactRelationshipType',
			'foreignKey' => 'contact_relationship_type_id',
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
		),
		'Relator' => array(
			'className' => 'Contact',
			'foreignKey' => 'related_contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>