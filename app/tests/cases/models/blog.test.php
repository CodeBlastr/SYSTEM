<?php 
/* SVN FILE: $Id$ */
/* Blog Test cases generated on: 2009-12-13 23:58:53 : 1260766733*/
App::import('Model', 'Blog');

class BlogTestCase extends CakeTestCase {
	var $Blog = null;
	var $fixtures = array('app.blog', 'app.user', 'app.blog_post', 'app.blog_user_group');

	function startTest() {
		$this->Blog =& ClassRegistry::init('Blog');
	}

	function testBlogInstance() {
		$this->assertTrue(is_a($this->Blog, 'Blog'));
	}

	function testBlogFind() {
		$this->Blog->recursive = -1;
		$results = $this->Blog->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Blog' => array(
			'id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'start_page'  => 'Lorem ipsum dolor sit amet',
			'public'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-13 23:58:53',
			'modified'  => '2009-12-13 23:58:53'
		));
		$this->assertEqual($results, $expected);
	}
}
?>