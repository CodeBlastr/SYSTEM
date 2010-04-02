<?php 
/* SVN FILE: $Id$ */
/* BlogPostTag Test cases generated on: 2009-12-13 23:56:04 : 1260766564*/
App::import('Model', 'BlogPostTag');

class BlogPostTagTestCase extends CakeTestCase {
	var $BlogPostTag = null;
	var $fixtures = array('app.blog_post_tag', 'app.tag', 'app.blog_post');

	function startTest() {
		$this->BlogPostTag =& ClassRegistry::init('BlogPostTag');
	}

	function testBlogPostTagInstance() {
		$this->assertTrue(is_a($this->BlogPostTag, 'BlogPostTag'));
	}

	function testBlogPostTagFind() {
		$this->BlogPostTag->recursive = -1;
		$results = $this->BlogPostTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogPostTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'blog_post_id'  => 1,
			'created'  => '2009-12-13 23:56:04',
			'modified'  => '2009-12-13 23:56:04'
		));
		$this->assertEqual($results, $expected);
	}
}
?>