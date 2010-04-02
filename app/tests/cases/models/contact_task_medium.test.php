<?php 
/* SVN FILE: $Id$ */
/* ContactTaskMedium Test cases generated on: 2009-12-14 00:40:03 : 1260769203*/
App::import('Model', 'ContactTaskMedium');

class ContactTaskMediumTestCase extends CakeTestCase {
	var $ContactTaskMedium = null;
	var $fixtures = array('app.contact_task_medium', 'app.medium', 'app.contact_task');

	function startTest() {
		$this->ContactTaskMedium =& ClassRegistry::init('ContactTaskMedium');
	}

	function testContactTaskMediumInstance() {
		$this->assertTrue(is_a($this->ContactTaskMedium, 'ContactTaskMedium'));
	}

	function testContactTaskMediumFind() {
		$this->ContactTaskMedium->recursive = -1;
		$results = $this->ContactTaskMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactTaskMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'contact_task_id'  => 1,
			'created'  => '2009-12-14 00:40:03',
			'modified'  => '2009-12-14 00:40:03'
		));
		$this->assertEqual($results, $expected);
	}
}
?>