<?php 
/* SVN FILE: $Id$ */
/* WikiPage Fixture generated on: 2010-02-14 18:13:20 : 1266189200*/

class WikiPageFixture extends CakeTestFixture {
	var $name = 'WikiPage';
	var $table = 'wiki_pages';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'wiki_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'title'  => 'Lorem ipsum dolor sit amet',
		'wiki_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-02-14 18:13:20',
		'modified'  => '2010-02-14 18:13:20'
	));
}
?>