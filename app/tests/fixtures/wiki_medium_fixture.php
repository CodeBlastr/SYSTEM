<?php 
/* SVN FILE: $Id$ */
/* WikiMedium Fixture generated on: 2009-12-14 01:03:11 : 1260770591*/

class WikiMediumFixture extends CakeTestFixture {
	var $name = 'WikiMedium';
	var $table = 'wiki_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'wiki_page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'wiki_page_id'  => 1,
		'created'  => '2009-12-14 01:03:11',
		'modified'  => '2009-12-14 01:03:11'
	));
}
?>