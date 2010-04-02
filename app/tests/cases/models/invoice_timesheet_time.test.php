<?php 
/* SVN FILE: $Id$ */
/* InvoiceTimesheetTime Test cases generated on: 2010-01-01 10:08:21 : 1262358501*/
App::import('Model', 'InvoiceTimesheetTime');

class InvoiceTimesheetTimeTestCase extends CakeTestCase {
	var $InvoiceTimesheetTime = null;
	var $fixtures = array('app.invoice_timesheet_time', 'app.creator', 'app.modifier');

	function startTest() {
		$this->InvoiceTimesheetTime =& ClassRegistry::init('InvoiceTimesheetTime');
	}

	function testInvoiceTimesheetTimeInstance() {
		$this->assertTrue(is_a($this->InvoiceTimesheetTime, 'InvoiceTimesheetTime'));
	}

	function testInvoiceTimesheetTimeFind() {
		$this->InvoiceTimesheetTime->recursive = -1;
		$results = $this->InvoiceTimesheetTime->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceTimesheetTime' => array(
			'id'  => 1,
			'invoice_id'  => 1,
			'timesheet_time_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-01 10:08:21',
			'modified'  => '2010-01-01 10:08:21'
		));
		$this->assertEqual($results, $expected);
	}
}
?>