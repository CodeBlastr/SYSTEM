<?php
class Enumeration extends AppModel {
	
	var $name = 'Enumeration';
	public $order = 'weight ASC';
	
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