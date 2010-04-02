<?php
class ProjectIssueStatusType extends AppModel {

	var $name = 'ProjectIssueStatusType';
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
		'ProjectIssue' => array(
			'className' => 'ProjectIssue',
			'foreignKey' => 'project_issue_status_type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ProjectIssue' => array(
			'className' => 'ProjectIssue',
			'foreignKey' => 'project_issue_status_type_id',
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