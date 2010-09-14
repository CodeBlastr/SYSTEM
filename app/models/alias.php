<?php
class Alias extends AppModel {

	var $name = 'Alias';
	var $validate = array(
		#'name' => array('notempty'),
		'alias' => array(
			'notemptyRule' => array(
			   'rule' =>'notempty',
			   'message' => 'Must have a value'
			),
			'uniqueRule' => array(
			   'rule' =>'isUnique',
			   'message' => 'Must be unique'
			),
			'alphaNumericDashUnderscore' => array(
			   'rule' => '|^[0-9a-zA-Z_-]*$|',
			   'message' => 'Can only be letters, numbers, and underscore'
			)
		),
	);

}
?>