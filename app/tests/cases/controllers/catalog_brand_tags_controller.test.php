<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandTagsController Test cases generated on: 2009-12-13 23:16:54 : 1260764214*/
App::import('Controller', 'CatalogBrandTags');

class TestCatalogBrandTags extends CatalogBrandTagsController {
	var $autoRender = false;
}

class CatalogBrandTagsControllerTest extends CakeTestCase {
	var $CatalogBrandTags = null;

	function startTest() {
		$this->CatalogBrandTags = new TestCatalogBrandTags();
		$this->CatalogBrandTags->constructClasses();
	}

	function testCatalogBrandTagsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogBrandTags, 'CatalogBrandTagsController'));
	}

	function endTest() {
		unset($this->CatalogBrandTags);
	}
}
?>