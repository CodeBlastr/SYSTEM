<?php 
/* SVN FILE: $Id$ */
/* CatalogBrandMediaController Test cases generated on: 2009-12-13 23:17:04 : 1260764224*/
App::import('Controller', 'CatalogBrandMedia');

class TestCatalogBrandMedia extends CatalogBrandMediaController {
	var $autoRender = false;
}

class CatalogBrandMediaControllerTest extends CakeTestCase {
	var $CatalogBrandMedia = null;

	function startTest() {
		$this->CatalogBrandMedia = new TestCatalogBrandMedia();
		$this->CatalogBrandMedia->constructClasses();
	}

	function testCatalogBrandMediaControllerInstance() {
		$this->assertTrue(is_a($this->CatalogBrandMedia, 'CatalogBrandMediaController'));
	}

	function endTest() {
		unset($this->CatalogBrandMedia);
	}
}
?>