<?php 
/* SVN FILE: $Id$ */
/* MediumTag Test cases generated on: 2009-12-14 00:48:17 : 1260769697*/
App::import('Model', 'MediumTag');

class MediumTagTestCase extends CakeTestCase {
	var $MediumTag = null;
	var $fixtures = array('app.medium_tag', 'app.tag', 'app.media');

	function startTest() {
		$this->MediumTag =& ClassRegistry::init('MediumTag');
	}

	function testMediumTagInstance() {
		$this->assertTrue(is_a($this->MediumTag, 'MediumTag'));
	}

	function testMediumTagFind() {
		$this->MediumTag->recursive = -1;
		$results = $this->MediumTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('MediumTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'media_id'  => 1,
			'created'  => '2009-12-14 00:48:17',
			'modified'  => '2009-12-14 00:48:17'
		));
		$this->assertEqual($results, $expected);
	}
}
?>