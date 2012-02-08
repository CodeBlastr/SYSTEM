<?php
/* Enumeration Test cases generated on: 2012-02-07 23:57:06 : 1328659026*/
App::uses('Enumeration', 'Model');

/**
 * Enumeration Test Case
 *
 */
class EnumerationTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.enumeration');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Enumeration = ClassRegistry::init('Enumeration');
	}
	
	public function testEnumerate() {
    	$result = $this->Enumeration->enumerate('anything');
	    $this->assertEquals(true, $result);
    }

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Enumeration);

		parent::tearDown();
	}

}
