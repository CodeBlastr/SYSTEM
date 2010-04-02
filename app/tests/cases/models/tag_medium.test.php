<?php 
/* SVN FILE: $Id$ */
/* TagMedium Test cases generated on: 2009-12-14 00:59:09 : 1260770349*/
App::import('Model', 'TagMedium');

class TagMediumTestCase extends CakeTestCase {
	var $TagMedium = null;
	var $fixtures = array('app.tag_medium', 'app.tag', 'app.medium');

	function startTest() {
		$this->TagMedium =& ClassRegistry::init('TagMedium');
	}

	function testTagMediumInstance() {
		$this->assertTrue(is_a($this->TagMedium, 'TagMedium'));
	}

	function testTagMediumFind() {
		$this->TagMedium->recursive = -1;
		$results = $this->TagMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TagMedium' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'medium_id'  => 1,
			'created'  => '2009-12-14 00:59:09',
			'modified'  => '2009-12-14 00:59:09'
		));
		$this->assertEqual($results, $expected);
	}
}
?>