<?php 
/* SVN FILE: $Id$ */
/* ContactActivity Test cases generated on: 2010-01-03 16:14:31 : 1262553271*/
App::import('Model', 'ContactActivity');

class ContactActivityTestCase extends CakeTestCase {
	var $ContactActivity = null;
	var $fixtures = array('app.contact_activity', 'app.parent', 'app.contact_activity_type', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactActivity =& ClassRegistry::init('ContactActivity');
	}

	function testContactActivityInstance() {
		$this->assertTrue(is_a($this->ContactActivity, 'ContactActivity'));
	}

	function testContactActivityFind() {
		$this->ContactActivity->recursive = -1;
		$results = $this->ContactActivity->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactActivity' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'contact_activity_type_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 16:14:30',
			'modified'  => '2010-01-03 16:14:30'
		));
		$this->assertEqual($results, $expected);
	}
}
?>