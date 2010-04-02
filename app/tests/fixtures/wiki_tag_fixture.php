<?php 
/* SVN FILE: $Id$ */
/* WikiTag Fixture generated on: 2009-12-14 01:03:42 : 1260770622*/

class WikiTagFixture extends CakeTestFixture {
	var $name = 'WikiTag';
	var $table = 'wiki_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'wiki_page_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'wiki_page_id'  => 1,
		'created'  => '2009-12-14 01:03:42',
		'modified'  => '2009-12-14 01:03:42'
	));
}
?>