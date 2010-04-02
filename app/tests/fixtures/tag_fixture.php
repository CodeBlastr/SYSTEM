<?php 
/* SVN FILE: $Id$ */
/* Tag Fixture generated on: 2010-01-05 22:13:35 : 1262747615*/

class TagFixture extends CakeTestFixture {
	var $name = 'Tag';
	var $table = 'tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'count' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'count'  => 1,
		'created'  => '2010-01-05 22:13:35',
		'modified'  => '2010-01-05 22:13:35'
	));
}
?>