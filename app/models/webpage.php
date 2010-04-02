<?php
class Webpage extends AppModel {
	var $name = 'Webpage';
	var $validate = array(
		'name' => array(
			'required' => VALID_NOT_EMPTY,
			'length' => array( 'rule' => array('maxLength', 100) ),
		),
		'title' => array(
			'required' => VALID_NOT_EMPTY,
			'length' => array( 'rule' => array('maxLength', 100) )
		),
		'alias' => array(
			'required' => VALID_NOT_EMPTY,
			'rule' => array('isUnique'), "message" => "Alias name is already in use. Please choose another")
	);
}
?>