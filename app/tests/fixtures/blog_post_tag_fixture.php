<?php 
/* SVN FILE: $Id$ */
/* BlogPostTag Fixture generated on: 2009-12-13 23:56:04 : 1260766564*/

class BlogPostTagFixture extends CakeTestFixture {
	var $name = 'BlogPostTag';
	var $table = 'blog_post_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'blog_post_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'blog_post_id'  => 1,
		'created'  => '2009-12-13 23:56:04',
		'modified'  => '2009-12-13 23:56:04'
	));
}
?>