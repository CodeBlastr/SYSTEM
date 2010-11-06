<?php
class Country extends AppModel {

	var $name = 'Country';
	var $validate = array(
		'name' => array('notempty')
	);
	var $userField = array(); # Used to define the creator table field (typically creator_id)
	var $userLevel = false; # Used to define if this model requires record level user access control?
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'ContactAddress' => array(
			'className' => 'ContactAddress',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	

}
?>