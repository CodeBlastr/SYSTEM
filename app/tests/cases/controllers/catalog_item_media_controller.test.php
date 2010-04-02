<?php 
/* SVN FILE: $Id$ */
/* CatalogItemMediaController Test cases generated on: 2009-12-14 00:05:19 : 1260767119*/
App::import('Controller', 'CatalogItemMedia');

class TestCatalogItemMedia extends CatalogItemMediaController {
	var $autoRender = false;
}

class CatalogItemMediaControllerTest extends CakeTestCase {
	var $CatalogItemMedia = null;

	function startTest() {
		$this->CatalogItemMedia = new TestCatalogItemMedia();
		$this->CatalogItemMedia->constructClasses();
	}

	function testCatalogItemMediaControllerInstance() {
		$this->assertTrue(is_a($this->CatalogItemMedia, 'CatalogItemMediaController'));
	}

	function endTest() {
		unset($this->CatalogItemMedia);
	}
}
?>