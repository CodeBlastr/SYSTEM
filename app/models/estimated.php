<?php
class Estimated extends AppModel {
	var $name = 'Estimated';
	var $useTable = 'estimated';
	var $validate = array(
		'estimate_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Estimate' => array(
			'className' => 'Estimate',
			'foreignKey' => 'estimate_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>