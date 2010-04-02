<?php
class ProjectIssue extends AppModel {

	var $name = 'ProjectIssue';
	var $actsAs = array('Tree');
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ProjectIssueParent' => array(
			'className' => 'ProjectIssue',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProjectIssuePriorityType' => array(
			'className' => 'ProjectIssuePriorityType',
			'foreignKey' => 'project_issue_priority_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProjectIssueStatusType' => array(
			'className' => 'ProjectIssueStatusType',
			'foreignKey' => 'project_issue_status_type_id',
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
		'Assignee' => array(
			'className' => 'User',
			'foreignKey' => 'assignee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProjectTrackerType' => array(
			'className' => 'ProjectTrackerType',
			'foreignKey' => 'project_tracker_type_id',
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

	var $hasMany = array(
		'TimesheetTime' => array(
			'className' => 'TimesheetTime',
			'foreignKey' => 'project_issue_id',
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