<?php
class ContactTask extends AppModel {

	var $name = 'ContactTask';
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ContactTaskParent' => array(
			'className' => 'ContactTask',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContactTaskType' => array(
			'className' => 'ContactTaskType',
			'foreignKey' => 'contact_task_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Assignee' => array(
			'className' => 'User',
			'foreignKey' => 'assignee_id',
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
			'joinTable' => 'contact_tasks_media',
			'foreignKey' => 'contact_task_id',
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