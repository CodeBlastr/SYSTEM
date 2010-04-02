<?php 
/* SVN FILE: $Id$ */
/* ProjectsWiki Fixture generated on: 2010-02-15 08:52:54 : 1266241974*/

class ProjectsWikiFixture extends CakeTestFixture {
	var $name = 'ProjectsWiki';
	var $table = 'projects_wikis';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'project_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'wiki_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'project_id'  => 1,
		'wiki_id'  => 1,
		'created'  => '2010-02-15 08:52:54',
		'modified'  => '2010-02-15 08:52:54'
	));
}
?>