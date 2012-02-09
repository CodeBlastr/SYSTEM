<?php
/* InstallController Test cases generated on: 2012-02-09 00:39:12 : 1328747952*/
App::uses('InstallController', 'Controller');

/**
 * TestConditions *
 */
class TestInstall extends InstallController {
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
class InstallTestCase extends ControllerTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Install = new TestInstall();
		#$this->Install->constructClasses();
	}

	public function testIndex() {
   		$result = $this->testAction('/install', array('return' => 'vars'));
		debug($result['unloadedPlugins']);
	}
	
	public function testPluginRedirect() {
   		$this->testAction('/install/plugin/');
		$this->assertContains('/install', $this->headers['Location']);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Install);

		parent::tearDown();
	}

}
