<?php
App::uses('PrivilegesAppModel', 'Privileges.Model');

class Requestor extends PrivilegesAppModel {

	public $name = 'Requestor'; 
	
	public $useTable = 'aros';
	
	public $displayField = 'model';
	
	public $actsAs = array('Tree');

	public $hasAndBelongsToMany = array(
		'Section'=>array(
			'className'=>'Privileges.Section',
			'joinTable'=>'aros_acos',
			'foreignKey'=>'aro_id',
			'associationForeignKey'=>'aco_id'
			)
		);
	
	/* I think, but I'm not sure that this is causing an error on the privileges index page,
	 * because the foreign_key is not unique.  (Sign and date please, I don't know how long this has been commented
	 * out, and probably should be removed by now.  7/23/2013 RK)
	public $belongsTo = array(
		'UserRole' => array(
	        'className' => 'Users.UserRole',
	    	'foreignKey' => 'foreign_key',
	        ),
		);*/
	
	public $hasMany = array(
		'Privilege' => array(
	    	'className'     => 'Privileges.Privilege',
	        'foreignKey'    => 'aro_id'
	        )
		);
	
}
