<?php
class Enumeration extends AppModel {
	
	var $name = 'Enumeration';
	var $order = 'weight ASC';
	
	public $valdiate = array(
		'type' => array(
			'rule1' => array(
				'rule' => array('maxLength',64),
				'message' => 'Enumeration type may not be longer then 64 characters.'
			)
		),
	);
	
/**
 * Just to test that this model exists (used in test cases)
 */
	public function enumerate($example = null) {
		if (!empty($example)) {
			return true;
		} else {
			return false;
		}
	}
		
}