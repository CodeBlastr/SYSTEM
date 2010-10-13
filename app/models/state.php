<?php
class State extends AppModel {

	var $name = 'State';
	var $validate = array(
		'name' => array('notempty')
	);
	var $userField = array();
	
	// Does this model requires user level access
	var $userLevel = false;

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ContactAddress' => array(
			'className' => 'ContactAddress',
			'foreignKey' => 'state_id',
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