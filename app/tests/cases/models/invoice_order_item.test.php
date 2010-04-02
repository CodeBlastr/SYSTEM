<?php 
/* SVN FILE: $Id$ */
/* InvoiceOrderItem Test cases generated on: 2009-12-14 00:46:09 : 1260769569*/
App::import('Model', 'InvoiceOrderItem');

class InvoiceOrderItemTestCase extends CakeTestCase {
	var $InvoiceOrderItem = null;
	var $fixtures = array('app.invoice_order_item', 'app.user', 'app.invoice', 'app.order');

	function startTest() {
		$this->InvoiceOrderItem =& ClassRegistry::init('InvoiceOrderItem');
	}

	function testInvoiceOrderItemInstance() {
		$this->assertTrue(is_a($this->InvoiceOrderItem, 'InvoiceOrderItem'));
	}

	function testInvoiceOrderItemFind() {
		$this->InvoiceOrderItem->recursive = -1;
		$results = $this->InvoiceOrderItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceOrderItem' => array(
			'id'  => 1,
			'user_id'  => 1,
			'invoice_id'  => 1,
			'order_id'  => 1,
			'created'  => '2009-12-14 00:46:09',
			'modified'  => '2009-12-14 00:46:09'
		));
		$this->assertEqual($results, $expected);
	}
}
?>