<?php
class WebpageMenu extends WebpagesAppModel {
	public $name = 'WebpageMenu';
	public $displayField = 'name';
	public $actsAs = array('Tree');
	public $validate = array();


/**
 * has many items, and we use this model instead of the MenuItem model for a performance boost 
 */
	public $hasMany = array(
		'WebpageMenuItem' => array(
			'className' => 'Webpages.WebpageMenuItem',
			'foreignKey' => 'menu_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'WebpageMenuItem.lft',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	public function types() {
		return array(
			'superfish' => 'Superfish', 
			'superfish sf-horizontal' => 'Superfish Horizontal', 
			'superfish sf-vertical' => 'Superfish Verticial'
			);
	}

}