<?php 
/* SVN FILE: $Id$ */
/* Country Fixture generated on: 2010-01-05 22:05:08 : 1262747108*/

class CountryFixture extends CakeTestFixture {
	var $name = 'Country';
	var $table = 'countries';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2010-01-05 22:05:08',
		'modified'  => '2010-01-05 22:05:08'
	));
}
?>