<?php
/* Setting Test cases generated on: 2012-01-13 02:12:14 : 1326420734*/
App::uses('Setting', 'Model');

/**
 * Setting Test Case
 *
 */
class SettingModelTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Setting',
		'app.Aco',
		'app.Aro',
		'app.ArosAco',
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Setting = ClassRegistry::init('Setting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Setting);

		parent::tearDown();
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}

/**
 * testPrepareSettingsIniDatum method
 *
 * @return void
 */
	public function testPrepareSettingsIniDatum() {

	}

/**
 * testFinishIniDatum method
 *
 * @return void
 */
	public function testFinishIniDatum() {

	}

/**
 * testWriteSettingsIniDatum method
 *
 * @return void
 */
	public function testWriteSettingsIniDatum() {

	}

/**
 * testWriteDefaultsIniDatum method
 *
 * @return void
 */
	public function testWriteDefaultsIniDatum() {

	}

/**
 * testGetName method
 *
 * @return void
 */
	public function testGetName() {

	}

/**
 * testGetDescription method
 *
 * @return void
 */
	public function testGetDescription() {

	}

/**
 * testType method
 *
 * @return void
 */
	public function testType() {

	}

/**
 * testGetFormSetting method
 *
 * @return void
 */
	public function testGetFormSetting() {

	}

}
