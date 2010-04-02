<?php 
/* SVN FILE: $Id$ */
/* MediumTag Fixture generated on: 2009-12-14 00:48:17 : 1260769697*/

class MediumTagFixture extends CakeTestFixture {
	var $name = 'MediumTag';
	var $table = 'medium_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'media_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'media_id'  => 1,
		'created'  => '2009-12-14 00:48:17',
		'modified'  => '2009-12-14 00:48:17'
	));
}
?>