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
	
	function beforeFind($queryData) {
		if (!empty($queryData['conditions'])) {
			return $queryData;
		} else {
			$queryData['conditions'] = array($this->alias.'.type' => $this->alias);
			return $queryData;
		}
	}
}
?>