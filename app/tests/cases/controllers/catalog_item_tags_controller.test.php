<?php 
/* SVN FILE: $Id$ */
/* CatalogItemTagsController Test cases generated on: 2009-12-13 23:33:07 : 1260765187*/
App::import('Controller', 'CatalogItemTags');

class TestCatalogItemTags extends CatalogItemTagsController {
	var $autoRender = false;
}

class CatalogItemTagsControllerTest extends CakeTestCase {
	var $CatalogItemTags = null;

	function startTest() {
		$this->CatalogItemTags = new TestCatalogItemTags();
		$this->CatalogItemTags->constructClasses();
	}

	function testCatalogItemTagsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogItemTags, 'CatalogItemTagsController'));
	}

	function endTest() {
		unset($this->CatalogItemTags);
	}
}
?>