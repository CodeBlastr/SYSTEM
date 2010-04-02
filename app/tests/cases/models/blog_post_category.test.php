<?php 
/* SVN FILE: $Id$ */
/* BlogPostCategory Test cases generated on: 2009-12-13 23:08:46 : 1260763726*/
App::import('Model', 'BlogPostCategory');

class BlogPostCategoryTestCase extends CakeTestCase {
	var $BlogPostCategory = null;
	var $fixtures = array('app.blog_post_category', 'app.user', 'app.blog_post_category', 'app.blog_post_category_relationship', 'app.blog_post_category_relationship');

	function startTest() {
		$this->BlogPostCategory =& ClassRegistry::init('BlogPostCategory');
	}

	function testBlogPostCategoryInstance() {
		$this->assertTrue(is_a($this->BlogPostCategory, 'BlogPostCategory'));
	}

	function testBlogPostCategoryFind() {
		$this->BlogPostCategory->recursive = -1;
		$results = $this->BlogPostCategory->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogPostCategory' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'use_count'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-13 23:08:46',
			'modified'  => '2009-12-13 23:08:46'
		));
		$this->assertEqual($results, $expected);
	}
}
?>