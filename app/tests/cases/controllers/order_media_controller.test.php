<?php 
/* SVN FILE: $Id$ */
/* OrderMediaController Test cases generated on: 2009-12-13 23:38:56 : 1260765536*/
App::import('Controller', 'OrderMedia');

class TestOrderMedia extends OrderMediaController {
	var $autoRender = false;
}

class OrderMediaControllerTest extends CakeTestCase {
	var $OrderMedia = null;

	function startTest() {
		$this->OrderMedia = new TestOrderMedia();
		$this->OrderMedia->constructClasses();
	}

	function testOrderMediaControllerInstance() {
		$this->assertTrue(is_a($this->OrderMedia, 'OrderMediaController'));
	}

	function endTest() {
		unset($this->OrderMedia);
	}
}
?>