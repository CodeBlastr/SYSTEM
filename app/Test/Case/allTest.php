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
 * app test files to run
 */
        // core controller files to run
		$suite->addTestFile($path . 'Controller' . DS . 'ConditionsControllerTest.php');
		$suite->addTestFile($path . 'Controller' . DS . 'InstallControllerTest.php');

		// core model files to run
		$suite->addTestFile($path . 'Model' . DS . 'EnumerationTest.php');
		$suite->addTestFile($path . 'Model' . DS . 'SettingTest.php');

    	// core model behavior files to run
		$suite->addTestFile($path . 'Model' . DS . 'Behavior' . DS. 'MetableBehaviorTest.php');



/**
 * plugins with test files to run
 */
		// Activities Plugin
		if (in_array('Activities', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Activities' . $controllerPath . DS .  'ActivitiesTest.php');
		}

		// Categories Plugin
		if (in_array('Categories', CakePlugin::loaded())) {
	        //$suite->addTestFile($pluginsPath . 'Categories' . $modelPath . DS . 'CategorizedTest.php');
			//$suite->addTestFile($pluginsPath . 'Categories' . $behaviorPath  . DS . 'CategorizableBehaviorTest.php');
		}

		// Drafts Plugin
		if (in_array('Drafts', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Drafts' . $modelPath . DS . 'DraftTest.php');
			$suite->addTestFile($pluginsPath . 'Drafts' . $behaviorPath  . DS . 'DraftableBehaviorTest.php');
		}

		// Estimates Plugin
		if (in_array('Estimates', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Estimates' . $modelPath . DS . 'EstimateTest.php');
		}

		// Forms Plugin
		if (in_array('Forms', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Forms' . $controllerPath . DS . 'FormsControllerTest.php');
		}

        // Galleries Plugin
		if (in_array('Galleries', CakePlugin::loaded())) {
	        $suite->addTestFile($pluginsPath . 'Galleries' . $modelPath . DS . 'GalleryTest.php');
	        $suite->addTestFile($pluginsPath . 'Galleries' . $modelPath . DS . 'GalleryImageTest.php');
		}

		// Orders Plugin
		if (in_array('Orders', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Orders' . $modelPath . DS . 'OrderItemTest.php');
		}

		// Products Plugin
		if (in_array('Products', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Products' . $modelPath . DS . 'ProductTest.php');
			$suite->addTestFile($pluginsPath . 'Products' . $modelPath . DS . 'ProductStoreTest.php');
		}
		
		// Users Plugin
		if (in_array('Users', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Users' . $behaviorPath . DS . 'UsableBehaviorTest.php');
		}

		// Webpages Plugin
		if (in_array('Webpages', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Webpages' . $modelPath . DS . 'WebpageTest.php');
		}

		// Workflows Plugin
		if (in_array('Workflows', CakePlugin::loaded())) {
			$suite->addTestFile($pluginsPath . 'Workflows' . $modelPath . DS . 'WorkflowEventTest.php');
			$suite->addTestFile($pluginsPath . 'Workflows' . $modelPath . DS . 'WorkflowItemEventTest.php');
		}
        
        
        
    	return $suite;
	}
}
