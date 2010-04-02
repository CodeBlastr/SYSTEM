<?php 
/* SVN FILE: $Id$ */
/* Media Fixture generated on: 2009-12-14 00:47:59 : 1260769679*/

class MediaFixture extends CakeTestFixture {
	var $name = 'Media';
	var $table = 'media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'media_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'type' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'size' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'data' => array('type'=>'binary', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'media_type_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'type'  => 'Lorem ipsum dolor sit amet',
		'size'  => 1,
		'data'  => 1,
		'user_id'  => 1,
		'created'  => '2009-12-14 00:47:59',
		'modified'  => '2009-12-14 00:47:59'
	));
}
?>