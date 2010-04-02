<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandsController Test cases generated on: 2009-12-13 23:17:14 : 1260764234*/
App::import('Controller', 'CatalogBrands');

class TestCatalogBrands extends CatalogBrandsController {
	var $autoRender = false;
}

class CatalogBrandsControllerTest extends CakeTestCase {
	var $CatalogBrands = null;

	function startTest() {
		$this->CatalogBrands = new TestCatalogBrands();
		$this->CatalogBrands->constructClasses();
	}

	function testCatalogBrandsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogBrands, 'CatalogBrandsController'));
	}

	function endTest() {
		unset($this->CatalogBrands);
	}
}
?>