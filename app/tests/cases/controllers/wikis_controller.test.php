<?php 
/* SVN FILE: $Id$ */
/* WikisController Test cases generated on: 2010-02-14 18:24:04 : 1266189844*/
App::import('Controller', 'Wikis');

class TestWikis extends WikisController {
	var $autoRender = false;
}

class WikisControllerTest extends CakeTestCase {
	var $Wikis = null;

	function startTest() {
		$this->Wikis = new TestWikis();
		$this->Wikis->constructClasses();
	}

	function testWikisControllerInstance() {
		$this->assertTrue(is_a($this->Wikis, 'WikisController'));
	}

	function endTest() {
		unset($this->Wikis);
	}
}
?>