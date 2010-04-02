<?php 
/* SVN FILE: $Id$ */
/* ContactTask Test cases generated on: 2010-01-03 21:34:35 : 1262572475*/
App::import('Model', 'ContactTask');

class ContactTaskTestCase extends CakeTestCase {
	var $ContactTask = null;
	var $fixtures = array('app.contact_task', 'app.parent', 'app.contact_task_type', 'app.assignee', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactTask =& ClassRegistry::init('ContactTask');
	}

	function testContactTaskInstance() {
		$this->assertTrue(is_a($this->ContactTask, 'ContactTask'));
	}

	function testContactTaskFind() {
		$this->ContactTask->recursive = -1;
		$results = $this->ContactTask->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactTask' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'contact_task_type_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'assignee_id'  => 1,
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 21:34:32',
			'modified'  => '2010-01-03 21:34:32'
		));
		$this->assertEqual($results, $expected);
	}
}
?>