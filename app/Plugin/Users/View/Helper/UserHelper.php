<?php
/**
 * User helper
 *
 * @package 	users
 * @subpackage 	users.views.helpers
 */
class UserHelper extends AppHelper {

/**
 * helpers variable
 *
 * @var array
 */
	public $helpers = array ('Html', 'Form', 'Js' => 'Jquery');

/**
 * Constructor method
 * 
 */
    public function __construct(View $View, $settings = array()) {
    	$this->View = $View;
    	//$this->defaults = array_merge($this->defaults, $settings);
		parent::__construct($View, $settings);
		App::uses('User', 'Users.Model');
		$this->User = new User();
    }

/**
 * Find method
 */
 	public function find($type = 'first', $params = array()) {
 		return $this->User->find($type, $params);
 	}

}