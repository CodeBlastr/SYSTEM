<?php 
/* SVN FILE: $Id$ */
/* BlogPostUserGroup Test cases generated on: 2009-12-13 23:56:45 : 1260766605*/
App::import('Model', 'BlogPostUserGroup');

class BlogPostUserGroupTestCase extends CakeTestCase {
	var $BlogPostUserGroup = null;
	var $fixtures = array('app.blog_post_user_group', 'app.blog_post', 'app.user_group');

	function startTest() {
		$this->BlogPostUserGroup =& ClassRegistry::init('BlogPostUserGroup');
	}

	function testBlogPostUserGroupInstance() {
		$this->assertTrue(is_a($this->BlogPostUserGroup, 'BlogPostUserGroup'));
	}

	function testBlogPostUserGroupFind() {
		$this->BlogPostUserGroup->recursive = -1;
		$results = $this->BlogPostUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogPostUserGroup' => array(
			'id'  => 1,
			'blog_post_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-13 23:56:45',
			'modified'  => '2009-12-13 23:56:45'
		));
		$this->assertEqual($results, $expected);
	}
}
?>