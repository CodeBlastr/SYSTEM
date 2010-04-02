<?php 
/* SVN FILE: $Id$ */
/* OrderTagsController Test cases generated on: 2009-12-13 23:39:32 : 1260765572*/
App::import('Controller', 'OrderTags');

class TestOrderTags extends OrderTagsController {
	var $autoRender = false;
}

class OrderTagsControllerTest extends CakeTestCase {
	var $OrderTags = null;

	function startTest() {
		$this->OrderTags = new TestOrderTags();
		$this->OrderTags->constructClasses();
	}

	function testOrderTagsControllerInstance() {
		$this->assertTrue(is_a($this->OrderTags, 'OrderTagsController'));
	}

	function endTest() {
		unset($this->OrderTags);
	}
}
?>