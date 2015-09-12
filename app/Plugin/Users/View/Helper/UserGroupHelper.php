<?php
/**
 * UserGroupHelper
 *
 * @package 	users
 * @subpackage 	users.views.helpers
 */
class UserGroupHelper extends AppHelper {

/**
 * helpers variable
 *
 * @var array
 */
	//public $helpers = array ('Html', 'Form', 'Js' => 'Jquery');

/**
 * Constructor method
 * 
 */
    // public function __construct(View $View, $settings = array()) {
    	// $this->View = $View;
    	// //$this->defaults = array_merge($this->defaults, $settings);
		// parent::__construct($View, $settings);
		// App::uses('User', 'Users.Model');
		// $this->User = new User();
    // }

/**
 * Find method
 */
 	public function find($type = 'first', $params = array()) {
 		App::uses('UserGroup', 'Users.Model');
		$UserGroup = new UserGroup();
 		return $UserGroup->find($type, $params);
 	}

}