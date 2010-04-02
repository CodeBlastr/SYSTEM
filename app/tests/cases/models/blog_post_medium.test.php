<?php 
/* SVN FILE: $Id$ */
/* BlogPostMedium Test cases generated on: 2009-12-13 23:55:33 : 1260766533*/
App::import('Model', 'BlogPostMedium');

class BlogPostMediumTestCase extends CakeTestCase {
	var $BlogPostMedium = null;
	var $fixtures = array('app.blog_post_medium', 'app.medium', 'app.blog_post');

	function startTest() {
		$this->BlogPostMedium =& ClassRegistry::init('BlogPostMedium');
	}

	function testBlogPostMediumInstance() {
		$this->assertTrue(is_a($this->BlogPostMedium, 'BlogPostMedium'));
	}

	function testBlogPostMediumFind() {
		$this->BlogPostMedium->recursive = -1;
		$results = $this->BlogPostMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogPostMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'blog_post_id'  => 1,
			'created'  => '2009-12-13 23:55:33',
			'modified'  => '2009-12-13 23:55:33'
		));
		$this->assertEqual($results, $expected);
	}
}
?>