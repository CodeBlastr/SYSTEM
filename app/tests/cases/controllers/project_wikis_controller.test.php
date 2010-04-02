<?php 
/* SVN FILE: $Id$ */
/* ProjectWikisController Test cases generated on: 2009-12-13 23:40:34 : 1260765634*/
App::import('Controller', 'ProjectWikis');

class TestProjectWikis extends ProjectWikisController {
	var $autoRender = false;
}

class ProjectWikisControllerTest extends CakeTestCase {
	var $ProjectWikis = null;

	function startTest() {
		$this->ProjectWikis = new TestProjectWikis();
		$this->ProjectWikis->constructClasses();
	}

	function testProjectWikisControllerInstance() {
		$this->assertTrue(is_a($this->ProjectWikis, 'ProjectWikisController'));
	}

	function endTest() {
		unset($this->ProjectWikis);
	}
}
?>