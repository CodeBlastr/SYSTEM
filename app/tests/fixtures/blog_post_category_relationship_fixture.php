<?php 
/* SVN FILE: $Id$ */
/* BlogPostCategoryRelationship Fixture generated on: 2009-12-13 23:09:40 : 1260763780*/

class BlogPostCategoryRelationshipFixture extends CakeTestFixture {
	var $name = 'BlogPostCategoryRelationship';
	var $table = 'blog_post_category_relationships';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'blog_post_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'blog_post_category_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'blog_post_id'  => 1,
		'blog_post_category_id'  => 1,
		'created'  => '2009-12-13 23:09:40',
		'modified'  => '2009-12-13 23:09:40'
	));
}
?>