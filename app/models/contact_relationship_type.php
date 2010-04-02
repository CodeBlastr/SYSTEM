<?php
class ContactRelationshipType extends AppModel {

	var $name = 'ContactRelationshipType';
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'ContactsRelationship' => array(
			'className' => 'ContactsRelationship',
			'foreignKey' => 'contact_relationship_type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>