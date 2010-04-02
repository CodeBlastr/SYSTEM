<?php 
/* SVN FILE: $Id$ */
/* Invoice Test cases generated on: 2010-01-03 16:28:57 : 1262554137*/
App::import('Model', 'Invoice');

class InvoiceTestCase extends CakeTestCase {
	var $Invoice = null;
	var $fixtures = array('app.invoice', 'app.assignee', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->Invoice =& ClassRegistry::init('Invoice');
	}

	function testInvoiceInstance() {
		$this->assertTrue(is_a($this->Invoice, 'Invoice'));
	}

	function testInvoiceFind() {
		$this->Invoice->recursive = -1;
		$results = $this->Invoice->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Invoice' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'conclusion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'sendto'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'due_date'  => '2010-01-03 16:28:57',
			'published'  => 1,
			'assignee_id'  => 1,
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 16:28:57',
			'modified'  => '2010-01-03 16:28:57'
		));
		$this->assertEqual($results, $expected);
	}
}
?>