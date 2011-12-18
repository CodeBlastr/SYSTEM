<?php
class MenuItem extends MenusAppModel {
	var $name = 'MenuItem';
	var $displayField = 'item_text';
	var $useTable = 'menus';
	var $actsAs = array('Tree');
	var $validate = array(
		'item_name' => array(
			'numeric' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'menu_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		# this would not work with the className as 'Menus.Menu'
		'Menu' => array(
			'className' => 'Menus.Menu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Menu.order'
		),
		'ParentMenuItem' => array(
			'className' => 'Menus.MenuItem',
			'foreignKey' => 'parent_id',
			'conditions' => array('ParentMenuItem.menu_id' => 1),
			'fields' => '',
			'order' => 'ParentMenuItem.order'
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
	
	var $hasMany = array(
		'ChildMenuItem' => array(
			'className' => 'Menus.MenuItem',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'ChildMenuItem.order',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	function add($data) {
		if ($this->save($data)) {
			return true;
		} else {
			throw new Exception(__d('menus', 'Item could not be saved. Please, try again.', true));
		}
	}
	
	function itemTargets() {
		return array('_blank' => '_blank', '_self' => '_self', '_parent' => '_parent', '_top' => '_top');
	}

}
?>