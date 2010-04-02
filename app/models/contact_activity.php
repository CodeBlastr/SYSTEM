<?php
class ContactActivity extends AppModel {

	var $name = 'ContactActivity';
	var $validate = array(
		'contact_activity_type_id' => array('numeric'),
		'name' => array('notempty'),
		'contact_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ContactActivityParent' => array(
			'className' => 'ContactActivity',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContactActivityType' => array(
			'className' => 'ContactActivityType',
			'foreignKey' => 'contact_activity_type_id',
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

	var $hasAndBelongsToMany = array(
		'Media' => array(
			'className' => 'Media',
			'joinTable' => 'contact_activities_media',
			'foreignKey' => 'contact_activity_id',
			'associationForeignKey' => 'media_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>