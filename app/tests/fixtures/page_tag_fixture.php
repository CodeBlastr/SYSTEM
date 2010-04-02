<?php 
/* SVN FILE: $Id$ */
/* PageTag Fixture generated on: 2009-12-14 00:55:27 : 1260770127*/

class PageTagFixture extends CakeTestFixture {
	var $name = 'PageTag';
	var $table = 'page_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'page_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'page_id'  => 1,
		'created'  => '2009-12-14 00:55:27',
		'modified'  => '2009-12-14 00:55:27'
	));
}
?>