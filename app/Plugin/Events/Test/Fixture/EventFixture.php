<?php
/**
 * EventFixture
 *
 */
class EventFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'event_schedule_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'start' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'used if event_schedule_id is null, does not support repeating events'),
		'end' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'used if event_schedule_id is null, does not support repeating events'),
		'tickets_total' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'used if event_venue_id is null, # of total tickets for sale'),
		'tickets_left' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'used if event_venue_id is null, # of tickets left'),
		'ticket_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'comment' => 'used if EventVenue is empty'),
		'is_public' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'comment' => 'overrides calendar settings'),
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
			'id' => '5087149f-3654-4699-9c5b-273c00000000',
			'event_schedule_id' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start' => '2012-10-23 22:05:19',
			'end' => '2012-10-23 22:05:19',
			'tickets_total' => 1,
			'tickets_left' => 1,
			'ticket_price' => 1,
			'is_public' => 1,
			'creator_id' => 'Lorem ipsum dolor sit amet',
			'modifier_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-23 22:05:19',
			'modified' => '2012-10-23 22:05:19'
		),
	);
}
