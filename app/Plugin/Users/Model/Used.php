<?php
App::uses('UsersAppModel', 'Users.Model');
/**
 * Used model
 *
 * @package users
 * @subpackage users.models
 */
class Used extends UsersAppModel {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Used';

/**
 * Table
 *
 * @var string
 */
	public $useTable = 'used';
	
/**
 * Belongs To Models
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',			
			));
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Constructor
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array();
	}

}
