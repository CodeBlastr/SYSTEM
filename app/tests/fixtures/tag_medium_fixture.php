<?php 
/* SVN FILE: $Id$ */
/* TagMedium Fixture generated on: 2009-12-14 00:59:09 : 1260770349*/

class TagMediumFixture extends CakeTestFixture {
	var $name = 'TagMedium';
	var $table = 'tag_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'medium_id'  => 1,
		'created'  => '2009-12-14 00:59:09',
		'modified'  => '2009-12-14 00:59:09'
	));
}
?>