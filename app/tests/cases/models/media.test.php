<?php 
/* SVN FILE: $Id$ */
/* Media Test cases generated on: 2009-12-14 00:47:59 : 1260769679*/
App::import('Model', 'Media');

class MediaTestCase extends CakeTestCase {
	var $Media = null;
	var $fixtures = array('app.media', 'app.media_type', 'app.user', 'app.medium_tag', 'app.medium_user_group');

	function startTest() {
		$this->Media =& ClassRegistry::init('Media');
	}

	function testMediaInstance() {
		$this->assertTrue(is_a($this->Media, 'Media'));
	}

	function testMediaFind() {
		$this->Media->recursive = -1;
		$results = $this->Media->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Media' => array(
			'id'  => 1,
			'media_type_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'type'  => 'Lorem ipsum dolor sit amet',
			'size'  => 1,
			'data'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-14 00:47:59',
			'modified'  => '2009-12-14 00:47:59'
		));
		$this->assertEqual($results, $expected);
	}
}
?>