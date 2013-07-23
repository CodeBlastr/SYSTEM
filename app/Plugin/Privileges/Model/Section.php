<?php
App::uses('PrivilegesAppModel', 'Privileges.Model');

class Section extends PrivilegesAppModel {

	public $name = 'Section'; 
	public $useTable = 'acos';
	public $displayField = 'alias';
	public $actsAs = array('Tree');
	
	public $hasAndBelongsToMany = array(
		'Requestor' => array(
			'className' => 'Privileges.Requestor',
			'joinTable' => 'aros_acos',
			'foreignKey' => 'aco_id',
			'associationForeignKey' => 'aro_id'
			)
		);

}
