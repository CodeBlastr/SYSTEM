<?php 
/* SVN FILE: $Id$ */
/* BlogPostCategoryRelationship Test cases generated on: 2009-12-13 23:09:40 : 1260763780*/
App::import('Model', 'BlogPostCategoryRelationship');

class BlogPostCategoryRelationshipTestCase extends CakeTestCase {
	var $BlogPostCategoryRelationship = null;
	var $fixtures = array('app.blog_post_category_relationship', 'app.blog_post', 'app.blog_post_category');

	function startTest() {
		$this->BlogPostCategoryRelationship =& ClassRegistry::init('BlogPostCategoryRelationship');
	}

	function testBlogPostCategoryRelationshipInstance() {
		$this->assertTrue(is_a($this->BlogPostCategoryRelationship, 'BlogPostCategoryRelationship'));
	}

	function testBlogPostCategoryRelationshipFind() {
		$this->BlogPostCategoryRelationship->recursive = -1;
		$results = $this->BlogPostCategoryRelationship->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogPostCategoryRelationship' => array(
			'id'  => 1,
			'blog_post_id'  => 1,
			'blog_post_category_id'  => 1,
			'created'  => '2009-12-13 23:09:40',
			'modified'  => '2009-12-13 23:09:40'
		));
		$this->assertEqual($results, $expected);
	}
}
?>