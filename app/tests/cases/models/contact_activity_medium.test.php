<?php 
/* SVN FILE: $Id$ */
/* ContactActivityMedium Test cases generated on: 2009-12-14 00:28:18 : 1260768498*/
App::import('Model', 'ContactActivityMedium');

class ContactActivityMediumTestCase extends CakeTestCase {
	var $ContactActivityMedium = null;
	var $fixtures = array('app.contact_activity_medium', 'app.medium', 'app.contact_activity');

	function startTest() {
		$this->ContactActivityMedium =& ClassRegistry::init('ContactActivityMedium');
	}

	function testContactActivityMediumInstance() {
		$this->assertTrue(is_a($this->ContactActivityMedium, 'ContactActivityMedium'));
	}

	function testContactActivityMediumFind() {
		$this->ContactActivityMedium->recursive = -1;
		$results = $this->ContactActivityMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactActivityMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'contact_activity_id'  => 1,
			'created'  => '2009-12-14 00:28:18',
			'modified'  => '2009-12-14 00:28:18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>