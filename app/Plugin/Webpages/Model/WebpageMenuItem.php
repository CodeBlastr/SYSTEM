<?php
class WebpageMenuItem extends WebpagesAppModel {
	public $name = 'WebpageMenuItem';
	public $displayField = 'item_text';
	public $useTable = 'webpage_menus';
	public $actsAs = array('Tree');
	public $validate = array(
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

	public $belongsTo = array(
		# this would not work with the className as 'Menus.Menu'
		'WebpageMenu' => array(
			'className' => 'Webpages.WebpageMenu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'WebpageMenu.order'
		),
		'ParentMenuItem' => array(
			'className' => 'Webpages.WebpageMenuItem',
			'foreignKey' => 'parent_id',
			'conditions' => array('ParentMenuItem.menu_id' => 1),
			'fields' => '',
			'order' => 'ParentMenuItem.order'
		)
	);
	
	public $hasMany = array(
		'ChildMenuItem' => array(
			'className' => 'Webpages.WebpageMenuItem',
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
	
	public function add($data) {
		if ($this->save($data)) {
			return true;
		} else {
			throw new Exception(__d('menus', 'Item could not be saved. Please, try again.', true));
		}
	}
	
	public function itemTargets() {
		return array('_blank' => '_blank', '_self' => '_self', '_parent' => '_parent', '_top' => '_top');
	}

}