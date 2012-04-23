<?php
class AllTests extends PHPUnit_Framework_TestSuite {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('All Tests');

		$path = APP_TEST_CASES . DS; // core tests
		$pluginsPath = APP . 'Plugin' . DS;
		$testPath = DS . 'Test' . DS . 'Case';
		$modelPath = $testPath . DS . 'Model';
		$controllerPath = $testPath . DS . 'Controller';

		$behaviorPath = $modelPath . DS . 'Behavior';
/**
 * core test files to run
 */
		// core controller files to run
		$suite->addTestFile($path . 'Controller' . DS . 'ConditionsControllerTest.php');
		$suite->addTestFile($path . 'Controller' . DS . 'InstallControllerTest.php');

		// core model files to run
		$suite->addTestFile($path . 'Model' . DS . 'EnumerationTest.php');
		$suite->addTestFile($path . 'Model' . DS . 'SettingTest.php');


/**
 * plugins with test files to run
 */
		// Activities Plugin
		if (in_array('Activities', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Activities' . $controllerPath . DS .  'ActivitiesTest.php');
		}

		// Drafts Plugin
		if (in_array('Drafts', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Drafts' . $modelPath . DS . 'DraftTest.php');
			$suite->addTestFile($pluginsPath . 'Drafts' . $behaviorPath  . DS . 'DraftableBehaviorTest.php');
		}

		// Forms Plugin
		if (in_array('Forms', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Forms' . $controllerPath . DS . 'FormsControllerTest.php');
		}

        // Galleries Plugin
		if (in_array('Galleries', CakePlugin::loaded())) {
	        $suite->addTestFile($pluginsPath . 'Galleries' . $modelPath . DS . 'GalleryTest.php');
		}

		// Orders Plugin
		if (in_array('Orders', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Orders' . $modelPath . DS . 'OrderItemTest.php');
		}

		// Workflows Plugin
		if (in_array('Workflows', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Workflows' . $modelPath . DS . 'WorkflowEventTest.php');
			$suite->addTestFile($pluginsPath . 'Workflows' . $modelPath . DS . 'WorkflowItemEventTest.php');
		}

		return $suite;
	}
}
