<?php 
/* SVN FILE: $Id$ */
/* PageHistory Fixture generated on: 2009-12-14 00:55:09 : 1260770109*/

class PageHistoryFixture extends CakeTestFixture {
	var $name = 'PageHistory';
	var $table = 'page_histories';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'description' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'description'  => 'Lorem ipsum dolor sit amet',
		'user_id'  => 1,
		'page_id'  => 1,
		'created'  => '2009-12-14 00:55:09',
		'modified'  => '2009-12-14 00:55:09'
	));
}
?>