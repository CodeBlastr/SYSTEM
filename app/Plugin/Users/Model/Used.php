<?php
/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Categorized model
 *
 * @package categories
 * @subpackage categories.models
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
		$this->validate = array(
			/*'foreign_key' => array(
				'required' => array(
					'rule' => array(
						'notEmpty'
						),
					'required' => true,
					'allowEmpty' => false,
					'message' => __d('categories', 'Foreign key can not be empty', true)
					)
				),
			'category_id' => array(
				'required' => array(
					'rule' => array(
						'notEmpty'
						),
					'required' => true,
					'allowEmpty' => false,
					'message' => __d('categories', 'Category id can not be empty', true)
					)
				),
			'model' => array(
				'required' => array(
					'rule' => array(
						'notEmpty'
						),
					'required' => true,
					'allowEmpty' => false,
					'message' => __d('categories', 'Model field can not be empty', true)
					)
				)*/
			);
	}

}
