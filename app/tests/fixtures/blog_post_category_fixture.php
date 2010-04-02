<?php 
/* SVN FILE: $Id$ */
/* BlogPostCategory Fixture generated on: 2009-12-13 23:08:46 : 1260763726*/

class BlogPostCategoryFixture extends CakeTestFixture {
	var $name = 'BlogPostCategory';
	var $table = 'blog_post_categories';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'use_count' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'use_count'  => 1,
		'user_id'  => 1,
		'created'  => '2009-12-13 23:08:46',
		'modified'  => '2009-12-13 23:08:46'
	));
}
?>