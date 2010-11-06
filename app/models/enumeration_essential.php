<?php
class EnumerationEssential extends AppModel {
	var $name = 'EnumerationEssential';
	var $order = 'weight ASC';
	
	var $userField = array(); # Used to define the creator table field (typically creator_id)
	var $userLevel = false; # Used to define if this model requires record level user access control?
	
	public $valdiate = array(
		'type' => array(
			'rule1' => array(
				'rule' => array('maxLength',64),
				'message' => 'Enumeration type may not be longer then 64 characters.'
			)
		),
	);
	
	
}
?>