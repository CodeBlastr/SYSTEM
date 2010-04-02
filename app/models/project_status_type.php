<?php
class ProjectStatusType extends AppModel {

	var $name = 'ProjectStatusType';
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_status_type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_status_type_id',
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