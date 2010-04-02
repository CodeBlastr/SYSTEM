<?php 
/* SVN FILE: $Id$ */
/* WikiPagesTag Fixture generated on: 2010-02-14 18:15:23 : 1266189323*/

class WikiPagesTagFixture extends CakeTestFixture {
	var $name = 'WikiPagesTag';
	var $table = 'wiki_pages_tags';
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
		'created'  => '2010-02-14 18:15:23',
		'modified'  => '2010-02-14 18:15:23'
	));
}
?>