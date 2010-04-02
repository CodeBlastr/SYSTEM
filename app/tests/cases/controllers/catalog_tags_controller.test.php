<?php 
/* SVN FILE: $Id$ */
/* CatalogTagsController Test cases generated on: 2009-12-13 23:33:22 : 1260765202*/
App::import('Controller', 'CatalogTags');

class TestCatalogTags extends CatalogTagsController {
	var $autoRender = false;
}

class CatalogTagsControllerTest extends CakeTestCase {
	var $CatalogTags = null;

	function startTest() {
		$this->CatalogTags = new TestCatalogTags();
		$this->CatalogTags->constructClasses();
	}

	function testCatalogTagsControllerInstance() {
		$this->assertTrue(is_a($this->CatalogTags, 'CatalogTagsController'));
	}

	function endTest() {
		unset($this->CatalogTags);
	}
}
?>