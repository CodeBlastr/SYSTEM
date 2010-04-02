<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheetItem Test cases generated on: 2009-12-14 00:46:34 : 1260769594*/
App::import('Model', 'InvoiceTimesheetItem');

class InvoiceTimesheetItemTestCase extends CakeTestCase {
	var $InvoiceTimesheetItem = null;
	var $fixtures = array('app.invoice_timesheet_item', 'app.user', 'app.invoice', 'app.timesheet_time');

	function startTest() {
		$this->InvoiceTimesheetItem =& ClassRegistry::init('InvoiceTimesheetItem');
	}

	function testInvoiceTimesheetItemInstance() {
		$this->assertTrue(is_a($this->InvoiceTimesheetItem, 'InvoiceTimesheetItem'));
	}

	function testInvoiceTimesheetItemFind() {
		$this->InvoiceTimesheetItem->recursive = -1;
		$results = $this->InvoiceTimesheetItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceTimesheetItem' => array(
			'id'  => 1,
			'user_id'  => 1,
			'invoice_id'  => 1,
			'timesheet_time_id'  => 1,
			'created'  => '2009-12-14 00:46:34',
			'modified'  => '2009-12-14 00:46:34'
		));
		$this->assertEqual($results, $expected);
	}
}
?>