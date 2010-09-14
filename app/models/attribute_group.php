<?php
class AttributeGroup extends AppModel {

	var $name = 'AttributeGroup';	
	var $validate = array(
		'name' => array('notempty'),
		'model' => array('notempty'),
	);
	
	var $userField = array();
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Attribute' => array(
			'className' => 'Attribute',
			'foreignKey' => 'attribute_group_id',
			'dependent' => true,
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
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Enumeration' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'enumeration_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>