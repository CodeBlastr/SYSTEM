<?php 
/* SVN FILE: $Id$ */
/* BlogComment Fixture generated on: 2009-12-13 23:05:21 : 1260763521*/

class BlogCommentFixture extends CakeTestFixture {
	var $name = 'BlogComment';
	var $table = 'blog_comments';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'text' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'commenter_name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'commenter_email' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'ip_address' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'spam' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'public' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'blog_post_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'commenter_name'  => 'Lorem ipsum dolor sit amet',
		'commenter_email'  => 'Lorem ipsum dolor sit amet',
		'ip_address'  => 'Lorem ipsum dolor sit amet',
		'spam'  => 1,
		'public'  => 1,
		'user_id'  => 1,
		'blog_post_id'  => 1,
		'created'  => '2009-12-13 23:05:21',
		'modified'  => '2009-12-13 23:05:21'
	));
}
?>