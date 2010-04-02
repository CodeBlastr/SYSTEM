<?php 
/* SVN FILE: $Id$ */
/* CatalogsController Test cases generated on: 2009-12-13 23:17:21 : 1260764241*/
App::import('Controller', 'Catalogs');

class TestCatalogs extends CatalogsController {
	var $autoRender = false;
}

class CatalogsControllerTest extends CakeTestCase {
	var $Catalogs = null;

	function startTest() {
		$this->Catalogs = new TestCatalogs();
		$this->Catalogs->constructClasses();
	}

	function testCatalogsControllerInstance() {
		$this->assertTrue(is_a($this->Catalogs, 'CatalogsController'));
	}

	function endTest() {
		unset($this->Catalogs);
	}
}
?>