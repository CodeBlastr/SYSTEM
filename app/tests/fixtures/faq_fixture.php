<?php
/* Faq Fixture generated on: 2011-03-24 07:03:30 : 1300951290 */
class FaqFixture extends CakeTestFixture {
	var $name = 'Faq';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'question' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'answer' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'order' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'public' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'creator_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'question' => 'Lorem ipsum dolor sit amet',
			'answer' => 'Lorem ipsum dolor sit amet',
			'order' => 1,
			'public' => 1,
			'creator_id' => 1,
			'modifier_id' => 1,
			'created' => '2011-03-24 07:21:30',
			'modified' => '2011-03-24 07:21:30'
		),
	);
}
?>