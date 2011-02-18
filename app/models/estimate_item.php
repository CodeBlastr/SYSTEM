<?php
class EstimateItem extends AppModel {
	var $name = 'EstimateItem';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Estimate' => array(
			'className' => 'Estimate',
			'foreignKey' => 'estimate_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EstimateItemType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'estimate_item_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>