<?php 
/* SVN FILE: $Id$ */
/* CatalogItemsController Test cases generated on: 2009-12-13 23:32:28 : 1260765148*/
App::import('Controller', 'CatalogItems');

class TestCatalogItems extends CatalogItemsController {
	var $autoRender = false;
}

class CatalogItemsControllerTest extends CakeTestCase {
	var $CatalogItems = null;

	function startTest() {
		$this->CatalogItems = new TestCatalogItems();
		$this->CatalogItems->constructClasses();
	}

	function testCatalogItemsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogItems, 'CatalogItemsController'));
	}

	function endTest() {
		unset($this->CatalogItems);
	}
}
?>