<?php
/**
 * TransactionCouponFixture
 *
 */
class TransactionCouponFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'conditions' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => 'a serialized list of condition variables -- filling this will be ui based', 'charset' => 'utf8'),
		'discount' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'discount_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'flat for the whole cart, percentage of the total cart, buy x get y free', 'charset' => 'utf8'),
		'discount_max' => array('type' => 'float', 'null' => true, 'default' => NULL, 'comment' => 'maximum the discount can be'),
		'discount_qty_x' => array('type' => 'float', 'null' => true, 'default' => NULL, 'comment' => 'number of items needed to qualify for the discount'),
		'discount_shipping' => array('type' => 'boolean', 'null' => true, 'default' => NULL, 'comment' => 'whether or not to discount the shipping as well'),
		'code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'uses_allowed' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'comment' => 'total number of times this coupon can be used'),
		'user_uses_allowed' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'comment' => 'number of times this coupon can be used per user'),
		'uses' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10),
		'start_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'end_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '50772060-ddfc-47ee-a1c1-194c00000000',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'conditions' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'discount' => 1,
			'discount_type' => 'Lorem ipsum dolor sit amet',
			'discount_max' => 1,
			'discount_qty_x' => 1,
			'discount_shipping' => 1,
			'code' => 'Lorem ipsum dolor sit amet',
			'uses_allowed' => 1,
			'user_uses_allowed' => 1,
			'uses' => 1,
			'start_date' => '2012-10-11 19:39:12',
			'end_date' => '2012-10-11 19:39:12',
			'is_active' => 1,
			'creator_id' => 'Lorem ipsum dolor sit amet',
			'modifier_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-11 19:39:12',
			'modified' => '2012-10-11 19:39:12'
		),
	);
}
