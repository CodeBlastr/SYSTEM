<?php 
/* SVN FILE: $Id$ */
/* CatalogMediaController Test cases generated on: 2009-12-13 23:33:17 : 1260765197*/
App::import('Controller', 'CatalogMedia');

class TestCatalogMedia extends CatalogMediaController {
	var $autoRender = false;
}

class CatalogMediaControllerTest extends CakeTestCase {
	var $CatalogMedia = null;

	function startTest() {
		$this->CatalogMedia = new TestCatalogMedia();
		$this->CatalogMedia->constructClasses();
	}

	function testCatalogMediaControllerInstance() {
		$this->assertTrue(is_a($this->CatalogMedia, 'CatalogMediaController'));
	}

	function endTest() {
		unset($this->CatalogMedia);
	}
}
?>