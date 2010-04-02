<?php 
/* SVN FILE: $Id$ */
/* CatalogItemFilesController Test cases generated on: 2009-12-13 23:32:44 : 1260765164*/
App::import('Controller', 'CatalogItemFiles');

class TestCatalogItemFiles extends CatalogItemFilesController {
	var $autoRender = false;
}

class CatalogItemFilesControllerTest extends CakeTestCase {
	var $CatalogItemFiles = null;

	function startTest() {
		$this->CatalogItemFiles = new TestCatalogItemFiles();
		$this->CatalogItemFiles->constructClasses();
	}

	function testCatalogItemFilesControllerInstance() {
		$this->assertTrue(is_a($this->CatalogItemFiles, 'CatalogItemFilesController'));
	}

	function endTest() {
		unset($this->CatalogItemFiles);
	}
}
?>