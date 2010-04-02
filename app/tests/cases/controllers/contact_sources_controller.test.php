<?php 
/* SVN FILE: $Id$ */
/* ContactSourcesController Test cases generated on: 2009-12-13 23:35:19 : 1260765319*/
App::import('Controller', 'ContactSources');

class TestContactSources extends ContactSourcesController {
	var $autoRender = false;
}

class ContactSourcesControllerTest extends CakeTestCase {
	var $ContactSources = null;

	function startTest() {
		$this->ContactSources = new TestContactSources();
		$this->ContactSources->constructClasses();
	}

	function testContactSourcesControllerInstance() {
		$this->assertTrue(is_a($this->ContactSources, 'ContactSourcesController'));
	}

	function endTest() {
		unset($this->ContactSources);
	}
}
?>