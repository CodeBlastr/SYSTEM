<?php 
/* SVN FILE: $Id$ */
/* ContactRatingsController Test cases generated on: 2009-12-13 23:35:04 : 1260765304*/
App::import('Controller', 'ContactRatings');

class TestContactRatings extends ContactRatingsController {
	var $autoRender = false;
}

class ContactRatingsControllerTest extends CakeTestCase {
	var $ContactRatings = null;

	function startTest() {
		$this->ContactRatings = new TestContactRatings();
		$this->ContactRatings->constructClasses();
	}

	function testContactRatingsControllerInstance() {
		$this->assertTrue(is_a($this->ContactRatings, 'ContactRatingsController'));
	}

	function endTest() {
		unset($this->ContactRatings);
	}
}
?>