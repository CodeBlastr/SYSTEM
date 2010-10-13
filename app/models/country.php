<?php
class Country extends AppModel {

	var $name = 'Country';
	var $validate = array(
		'name' => array('notempty')
	);
	var $userField = array();

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
	
	// Does this model requires user level access
	var $userLevel = false;

}
?>