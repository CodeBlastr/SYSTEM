<?php
class EnumerationEssential extends AppModel {
	var $name = 'EnumerationEssential';
	var $userField = array();
	public $order = 'weight ASC';
	
	public $valdiate = array(
		'type' => array(
			'rule1' => array(
				'rule' => array('maxLength',64),
				'message' => 'Enumeration type may not be longer then 64 characters.'
			)
		),
	);
	
	// Does this model requires user level access
	var $userLevel = false;
}
?>