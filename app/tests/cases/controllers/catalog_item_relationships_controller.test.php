<?php 
/* SVN FILE: $Id$ */
/* CatalogItemRelationshipsController Test cases generated on: 2009-12-13 23:32:51 : 1260765171*/
App::import('Controller', 'CatalogItemRelationships');

class TestCatalogItemRelationships extends CatalogItemRelationshipsController {
	var $autoRender = false;
}

class CatalogItemRelationshipsControllerTest extends CakeTestCase {
	var $CatalogItemRelationships = null;

	function startTest() {
		$this->CatalogItemRelationships = new TestCatalogItemRelationships();
		$this->CatalogItemRelationships->constructClasses();
	}

	function testCatalogItemRelationshipsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogItemRelationships, 'CatalogItemRelationshipsController'));
	}

	function endTest() {
		unset($this->CatalogItemRelationships);
	}
}
?>