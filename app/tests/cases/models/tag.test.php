<?php 
/* SVN FILE: $Id$ */
/* Tag Test cases generated on: 2010-01-05 22:13:38 : 1262747618*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $Tag = null;
	var $fixtures = array('app.tag', 'app.parent');

	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}

	function testTagInstance() {
		$this->assertTrue(is_a($this->Tag, 'Tag'));
	}

	function testTagFind() {
		$this->Tag->recursive = -1;
		$results = $this->Tag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Tag' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'count'  => 1,
			'created'  => '2010-01-05 22:13:35',
			'modified'  => '2010-01-05 22:13:35'
		));
		$this->assertEqual($results, $expected);
	}
}
?>