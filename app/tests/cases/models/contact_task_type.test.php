<?php 
/* SVN FILE: $Id$ */
/* ContactTaskType Test cases generated on: 2009-12-14 00:42:08 : 1260769328*/
App::import('Model', 'ContactTaskType');

class ContactTaskTypeTestCase extends CakeTestCase {
	var $ContactTaskType = null;
	var $fixtures = array('app.contact_task_type', 'app.contact_task');

	function startTest() {
		$this->ContactTaskType =& ClassRegistry::init('ContactTaskType');
	}

	function testContactTaskTypeInstance() {
		$this->assertTrue(is_a($this->ContactTaskType, 'ContactTaskType'));
	}

	function testContactTaskTypeFind() {
		$this->ContactTaskType->recursive = -1;
		$results = $this->ContactTaskType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactTaskType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 00:42:06',
			'modified'  => '2009-12-14 00:42:06'
		));
		$this->assertEqual($results, $expected);
	}
}
?>