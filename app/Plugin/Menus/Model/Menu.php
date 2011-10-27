<?php
class Menu extends MenusAppModel {
	var $name = 'Menu';
	var $displayField = 'name';
	var $actsAs = array('Tree');
	var $validate = array();
	
	
	var $belongsTo = array(
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


	/**
	 * has many items, and we use this model instead of the MenuItem model for a performance boost 
	 */
	var $hasMany = array(
		'MenuItem' => array(
			'className' => 'Menus.MenuItem',
			'foreignKey' => 'menu_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'MenuItem.lft',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	function types() {
		return array('superfish' => 'Superfish', 
					 'superfish sf-horizontal' => 'Superfish Horizontal', 
					 'superfish sf-vertical' => 'Superfish Verticial');
	}

}
?>