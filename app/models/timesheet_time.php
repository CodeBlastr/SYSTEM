<?php
class TimesheetTime extends AppModel {

	var $name = 'TimesheetTime';
	var $validate = array(
		'project_id' => array('numeric')
	);
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProjectIssue' => array(
			'className' => 'ProjectIssue',
			'foreignKey' => 'project_issue_id',
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
		'Invoice' => array(
			'className' => 'Invoice',
			'joinTable' => 'invoices_timesheet_times',
			'foreignKey' => 'timesheet_time_id',
			'associationForeignKey' => 'invoice_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Timesheet' => array(
			'className' => 'Timesheet',
			'joinTable' => 'timesheets_timesheet_times',
			'foreignKey' => 'timesheet_time_id',
			'associationForeignKey' => 'timesheet_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'CatalogItem' => array(
			'className' => 'CatalogItem',
			'joinTable' => 'timesheet_times_catalog_items',
			'foreignKey' => 'timesheet_time_id',
			'associationForeignKey' => 'catalog_item_id',
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