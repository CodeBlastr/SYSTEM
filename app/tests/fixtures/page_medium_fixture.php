<?php 
/* SVN FILE: $Id$ */
/* PageMedium Fixture generated on: 2009-12-14 00:55:17 : 1260770117*/

class PageMediumFixture extends CakeTestFixture {
	var $name = 'PageMedium';
	var $table = 'page_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'page_id'  => 1,
		'created'  => '2009-12-14 00:55:17',
		'modified'  => '2009-12-14 00:55:17'
	));
}
?>