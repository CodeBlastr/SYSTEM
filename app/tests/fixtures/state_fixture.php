<?php 
/* SVN FILE: $Id$ */
/* State Fixture generated on: 2010-01-05 22:04:25 : 1262747065*/

class StateFixture extends CakeTestFixture {
	var $name = 'State';
	var $table = 'states';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'country_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'country_id'  => 1,
		'created'  => '2010-01-05 22:04:25',
		'modified'  => '2010-01-05 22:04:25'
	));
}
?>