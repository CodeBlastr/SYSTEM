<?php 
/* SVN FILE: $Id$ */
/* BlogComment Test cases generated on: 2009-12-13 23:05:21 : 1260763521*/
App::import('Model', 'BlogComment');

class BlogCommentTestCase extends CakeTestCase {
	var $BlogComment = null;
	var $fixtures = array('app.blog_comment', 'app.user', 'app.blog_post', 'app.blog_comment');

	function startTest() {
		$this->BlogComment =& ClassRegistry::init('BlogComment');
	}

	function testBlogCommentInstance() {
		$this->assertTrue(is_a($this->BlogComment, 'BlogComment'));
	}

	function testBlogCommentFind() {
		$this->BlogComment->recursive = -1;
		$results = $this->BlogComment->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogComment' => array(
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
		$this->assertEqual($results, $expected);
	}
}
?>