<?php
class Attribute extends AppModel {

	var $name = 'Attribute';
	var $userField = array();
	var $validate = array(
		'attribute_group_id' => array('numeric'),
	    'code' => array(
	    	'rule' => '/^[a-z0-9_]{3,50}$/i',  
	        'message' => 'Only lowercase letters, integers, underscores, and min 3 and 50 characters'
	    ),
		'name' => array('notempty'),
		'input_type_id' => array('numeric'),
		'input_type_id' => array('numeric'),
		'is_unique' => array('numeric'),
		'is_required' => array('numeric'),
		'is_quicksearch' => array('numeric'),
		'is_advancedsearch' => array('numeric'),
		'is_comparable' => array('numeric'),
		'is_layered' => array('numeric'),
		'is_visible' => array('numeric'),
	); 
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'AttributeGroup' => array(
			'className' => 'AttributeGroup',
			'foreignKey' => 'attribute_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	// Used to define if this model requires record level user access control? 
	var $userLevel = false;
}
?>