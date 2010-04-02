<?php 
/* SVN FILE: $Id$ */
/* ProjectWiki Fixture generated on: 2009-12-14 00:57:33 : 1260770253*/

class ProjectWikiFixture extends CakeTestFixture {
	var $name = 'ProjectWiki';
	var $table = 'project_wikis';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'start_page' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'public' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'wiki_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'start_page'  => 'Lorem ipsum dolor sit amet',
		'public'  => 1,
		'user_id'  => 1,
		'project_id'  => 1,
		'wiki_id'  => 1,
		'created'  => '2009-12-14 00:57:33',
		'modified'  => '2009-12-14 00:57:33'
	));
}
?>