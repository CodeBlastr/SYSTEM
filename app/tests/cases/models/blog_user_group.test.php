<?php 
/* SVN FILE: $Id$ */
/* BlogUserGroup Test cases generated on: 2009-12-13 23:58:17 : 1260766697*/
App::import('Model', 'BlogUserGroup');

class BlogUserGroupTestCase extends CakeTestCase {
	var $BlogUserGroup = null;
	var $fixtures = array('app.blog_user_group', 'app.blog', 'app.user_group');

	function startTest() {
		$this->BlogUserGroup =& ClassRegistry::init('BlogUserGroup');
	}

	function testBlogUserGroupInstance() {
		$this->assertTrue(is_a($this->BlogUserGroup, 'BlogUserGroup'));
	}

	function testBlogUserGroupFind() {
		$this->BlogUserGroup->recursive = -1;
		$results = $this->BlogUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogUserGroup' => array(
			'id'  => 1,
			'blog_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-13 23:58:17',
			'modified'  => '2009-12-13 23:58:17'
		));
		$this->assertEqual($results, $expected);
	}
}
?>