<?php 
/* SVN FILE: $Id$ */
/* CatalogItemRelationshipTypesController Test cases generated on: 2009-12-13 23:33:01 : 1260765181*/
App::import('Controller', 'CatalogItemRelationshipTypes');

class TestCatalogItemRelationshipTypes extends CatalogItemRelationshipTypesController {
	var $autoRender = false;
}

class CatalogItemRelationshipTypesControllerTest extends CakeTestCase {
	var $CatalogItemRelationshipTypes = null;

	function startTest() {
		$this->CatalogItemRelationshipTypes = new TestCatalogItemRelationshipTypes();
		$this->CatalogItemRelationshipTypes->constructClasses();
	}

	function testCatalogItemRelationshipTypesControllerInstance() {
		$this->assertTrue(is_a($this->CatalogItemRelationshipTypes, 'CatalogItemRelationshipTypesController'));
	}

	function endTest() {
		unset($this->CatalogItemRelationshipTypes);
	}
}
?>