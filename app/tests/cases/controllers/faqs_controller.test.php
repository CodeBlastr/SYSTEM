<?php 
/* SVN FILE: $Id$ */
/* FaqsController Test cases generated on: 2009-12-13 23:36:55 : 1260765415*/
App::import('Controller', 'Faqs');

class TestFaqs extends FaqsController {
	var $autoRender = false;
}

class FaqsControllerTest extends CakeTestCase {
	var $Faqs = null;

	function startTest() {
		$this->Faqs = new TestFaqs();
		$this->Faqs->constructClasses();
	}

	function testFaqsControllerInstance() {
		$this->assertTrue(is_a($this->Faqs, 'FaqsController'));
	}

	function endTest() {
		unset($this->Faqs);
	}
}
?>