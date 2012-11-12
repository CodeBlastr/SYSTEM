<?php
App::uses('AppModel', 'Model');

class Alias extends AppModel {

	public $name = 'Alias';
	
	public $validate = array(
		'name' => array(
			'notemptyRule' => array(
			   'rule' =>'notempty',
			   'message' => 'must have a value'
			),
			'uniqueRule' => array(
			   'rule' =>'isUnique',
			   'message' => 'must be unique'
			),
			'alphaNumericDashUnderscore' => array(
			   'rule' => '|^[0-9a-zA-Z_-]*$|',
			   'message' => 'can only be letters, numbers, and underscore'
			)
		),
	);

}
