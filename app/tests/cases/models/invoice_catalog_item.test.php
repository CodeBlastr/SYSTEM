<?php 
/* SVN FILE: $Id$ */
/* InvoiceCatalogItem Test cases generated on: 2009-12-14 00:45:53 : 1260769553*/
App::import('Model', 'InvoiceCatalogItem');

class InvoiceCatalogItemTestCase extends CakeTestCase {
	var $InvoiceCatalogItem = null;
	var $fixtures = array('app.invoice_catalog_item', 'app.user', 'app.invoice', 'app.catalog_item');

	function startTest() {
		$this->InvoiceCatalogItem =& ClassRegistry::init('InvoiceCatalogItem');
	}

	function testInvoiceCatalogItemInstance() {
		$this->assertTrue(is_a($this->InvoiceCatalogItem, 'InvoiceCatalogItem'));
	}

	function testInvoiceCatalogItemFind() {
		$this->InvoiceCatalogItem->recursive = -1;
		$results = $this->InvoiceCatalogItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceCatalogItem' => array(
			'id'  => 1,
			'quantity'  => 1,
			'user_id'  => 1,
			'invoice_id'  => 1,
			'catalog_item_id'  => 1,
			'created'  => '2009-12-14 00:45:53',
			'modified'  => '2009-12-14 00:45:53'
		));
		$this->assertEqual($results, $expected);
	}
}
?>