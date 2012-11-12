<?php
App::uses('Webpage', 'Webpages.Model');

/**
 * Product Test Case
 *
 */
class WebpageTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.Condition',
        'app.Alias',
        'plugin.Webpages.Webpage'
        );
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Webpage = ClassRegistry::init('Webpages.Webpage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Product);

		parent::tearDown();
	}

/**
 * testAdd method
 *
 * @return void
 * @todo this should not work, because validation should fail when there is no name
 */
	public function testSave() {
        
        $testData = array(
            'Webpage' => array(
                'type' => 'content'
                )
            );
        $result = $this->Webpage->add($testData);
        $this->assertTrue(!empty($this->Webpage->id));
        
	}

/**
 * testAddWithAlias method
 *
 * @return void
 */
	public function testSaveWithAlias() {
        
        $testData = array(
            'Webpage' => array(
                'type' => 'content'
                ),
            'Alias' => array(
                'name' => 'lorem-ipsum'
                )
            );
        $this->Webpage->add($testData);
        $result = $this->Webpage->find('first', array('conditions' => array('Webpage.id' => $this->Webpage->id), 'contain' => array('Alias')));
        $this->assertEqual($testData['Alias']['name'], $result['Alias']['name']);
        
	}
     
}
