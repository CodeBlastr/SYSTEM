<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheet Test cases generated on: 2010-01-02 15:47:47 : 1262465267*/
App::import('Model', 'InvoiceTimesheet');

class InvoiceTimesheetTestCase extends CakeTestCase {
	var $InvoiceTimesheet = null;
	var $fixtures = array('app.invoice_timesheet', 'app.invoice', 'app.timesheet', 'app.creator', 'app.modifier');

	function startTest() {
		$this->InvoiceTimesheet =& ClassRegistry::init('InvoiceTimesheet');
	}

	function testInvoiceTimesheetInstance() {
		$this->assertTrue(is_a($this->InvoiceTimesheet, 'InvoiceTimesheet'));
	}

	function testInvoiceTimesheetFind() {
		$this->InvoiceTimesheet->recursive = -1;
		$results = $this->InvoiceTimesheet->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceTimesheet' => array(
			'id'  => 1,
			'invoice_id'  => 1,
			'timesheet_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-02 15:47:47',
			'modified'  => '2010-01-02 15:47:47'
		));
		$this->assertEqual($results, $expected);
	}
}
?>