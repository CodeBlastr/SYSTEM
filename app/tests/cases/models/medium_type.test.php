<?php 
/* SVN FILE: $Id$ */
/* MediumType Test cases generated on: 2009-12-14 00:51:35 : 1260769895*/
App::import('Model', 'MediumType');

class MediumTypeTestCase extends CakeTestCase {
	var $MediumType = null;
	var $fixtures = array('app.medium_type', 'app.media');

	function startTest() {
		$this->MediumType =& ClassRegistry::init('MediumType');
	}

	function testMediumTypeInstance() {
		$this->assertTrue(is_a($this->MediumType, 'MediumType'));
	}

	function testMediumTypeFind() {
		$this->MediumType->recursive = -1;
		$results = $this->MediumType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('MediumType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-12-14 00:51:35',
			'modified'  => '2009-12-14 00:51:35'
		));
		$this->assertEqual($results, $expected);
	}
}
?>