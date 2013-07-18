<?php
class Requestor extends PrivilegesAppModel {

	var $name = 'Requestor'; 
	var $useTable = 'aros';
	var $displayField = 'model';
	var $actsAs = array('Tree');

	var $hasAndBelongsToMany = array(
		'Section'=>array(
			'className'=>'Privileges.Section',
			'joinTable'=>'aros_acos',
			'foreignKey'=>'aro_id',
			'associationForeignKey'=>'aco_id'
			)
		);
	
	/*  I think, but I'm not sure that this is causing an error on the privileges index page,
		because the foreign_key is not unique.
	var $belongsTo = array(
		'UserRole' => array(
	        'className' => 'Users.UserRole',
	    	'foreignKey' => 'foreign_key',
	        ),
		);*/
	
	var $hasMany = array(
		'Privilege' => array(
	    	'className'     => 'Privileges.Privilege',
	        'foreignKey'    => 'aro_id'
	        )
		);
	
}
?>
