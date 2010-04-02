<?php 
/* SVN FILE: $Id$ */
/* Blog Fixture generated on: 2009-12-13 23:58:53 : 1260766733*/

class BlogFixture extends CakeTestFixture {
	var $name = 'Blog';
	var $table = 'blogs';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'start_page' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'public' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'title'  => 'Lorem ipsum dolor sit amet',
		'start_page'  => 'Lorem ipsum dolor sit amet',
		'public'  => 1,
		'user_id'  => 1,
		'created'  => '2009-12-13 23:58:53',
		'modified'  => '2009-12-13 23:58:53'
	));
}
?>