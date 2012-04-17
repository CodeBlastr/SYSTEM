<?php
/* InstallController Test cases generated on: 2012-02-09 00:39:12 : 1328747952*/
App::uses('InstallController', 'Controller');

/**
 * TestInstall *
 */
class TestInstall extends CakeTestModel {
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
 * TestInstall *
 */
class Request {
	
	public $controller = 'install';
	public $action = 'site';
}

/**
 * Conditions Test Case
 *
 */
class InstallControllerTestCase extends ControllerTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.aco',
		'app.aro',
		'app.aros_aco',
		);
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Install = new TestInstall();
		$request = new Request();
		$this->InstallController = new InstallController($request);
		//$this->Install->constructClasses();
	}

	public function testIndex() {
   		$result = $this->testAction('/install', array('return' => 'vars'));
		$this->assertTrue(!empty($result['page_title_for_layout']));
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
