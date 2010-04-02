<?php 
/* SVN FILE: $Id$ */
/* InvoiceTag Test cases generated on: 2009-12-14 00:46:22 : 1260769582*/
App::import('Model', 'InvoiceTag');

class InvoiceTagTestCase extends CakeTestCase {
	var $InvoiceTag = null;
	var $fixtures = array('app.invoice_tag', 'app.tag', 'app.invoice');

	function startTest() {
		$this->InvoiceTag =& ClassRegistry::init('InvoiceTag');
	}

	function testInvoiceTagInstance() {
		$this->assertTrue(is_a($this->InvoiceTag, 'InvoiceTag'));
	}

	function testInvoiceTagFind() {
		$this->InvoiceTag->recursive = -1;
		$results = $this->InvoiceTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'invoice_id'  => 1,
			'created'  => '2009-12-14 00:46:22',
			'modified'  => '2009-12-14 00:46:22'
		));
		$this->assertEqual($results, $expected);
	}
}
?>