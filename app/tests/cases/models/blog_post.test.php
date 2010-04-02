<?php 
/* SVN FILE: $Id$ */
/* BlogPost Test cases generated on: 2009-12-13 23:57:34 : 1260766654*/
App::import('Model', 'BlogPost');

class BlogPostTestCase extends CakeTestCase {
	var $BlogPost = null;
	var $fixtures = array('app.blog_post', 'app.user', 'app.blog', 'app.blog_comment', 'app.blog_post_category_relationship', 'app.blog_post_medium', 'app.blog_post_tag', 'app.blog_post_user_group');

	function startTest() {
		$this->BlogPost =& ClassRegistry::init('BlogPost');
	}

	function testBlogPostInstance() {
		$this->assertTrue(is_a($this->BlogPost, 'BlogPost'));
	}

	function testBlogPostFind() {
		$this->BlogPost->recursive = -1;
		$results = $this->BlogPost->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BlogPost' => array(
			'id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'seo_title'  => 'Lorem ipsum dolor sit amet',
			'seo_keywords'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'seo_descriptions'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'public'  => 1,
			'user_id'  => 1,
			'blog_id'  => 1,
			'created'  => '2009-12-13 23:57:34',
			'modified'  => '2009-12-13 23:57:34'
		));
		$this->assertEqual($results, $expected);
	}
}
?>