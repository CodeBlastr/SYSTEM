<?php
/* Conditions Test cases generated on: 2012-02-09 00:39:12 : 1328747952*/
App::uses('ConditionsController', 'Controller');

/**
 * TestConditions *
 */
class TestConditions extends ConditionsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * Conditions Test Case
 *
 */
class ConditionsControllerTestCase extends ControllerTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Conditions = new TestConditions();
		#$this->Conditions->constructClasses();
	}

	public function testView() {
		# http://www.phpunit.de/manual/3.6/en/writing-tests-for-phpunit.html
   		//$result = $this->testAction('/conditions/view/1');
		//debug($result);
	}

	public function testViewRedirect() {
   		//$this->testAction('/conditions/view/');
		//$this->assertContains('/conditions', $this->headers['Location']);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Conditions);

		parent::tearDown();
	}

}
