<?php
class Enumeration extends AppModel {
	
	var $name = 'Enumeration';
	public $order = 'weight ASC';
	var $userField = array();
	
	public $valdiate = array(
		'type' => array(
			'rule1' => array(
				'rule' => array('maxLength',64),
				'message' => 'Enumeration type may not be longer then 64 characters.'
			)
		),
	);
	
	// Used to define if this model requires record level user access control? 
	var $userLevel = false;
}
?>