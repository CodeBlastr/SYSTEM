<?php
/**
 * EventScheduleFixture
 *
 */
class EventScheduleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'repeat_on' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2, 'comment' => 'used when weekly or monthly is the choice, to choose which days of the week, or which months'),
		'repeat_every' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'used to repeat every X days, or every X weeks on Tue, Thurs, or every other month, every 2 years, etc'),
		'start' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'end' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => ' if repeat_every is filled this field is calculated, if null the event never ends'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '508714fa-1dc8-42b4-afe8-195000000000',
			'repeat_on' => 1,
			'repeat_every' => 1,
			'start' => '2012-10-23 22:06:50',
			'end' => '2012-10-23 22:06:50',
			'creator_id' => 'Lorem ipsum dolor sit amet',
			'modifier_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-23 22:06:50',
			'modified' => '2012-10-23 22:06:50'
		),
	);
}
