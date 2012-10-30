<?php
App::uses('Contact', 'Contacts.Model');

/**
 * Contact Test Case
 *
 */
class ContactTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
        'plugin.activities.activity',
        );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contact = ClassRegistry::init('Contacts.Contact');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contact);

		parent::tearDown();
	}

/**
 * test Add method
 *
 * @return void
 */
	public function testAdd() {
		$data['Contact']['name'] = 'Fake Name';
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id)));
		
        $this->assertEqual($result['Contact']['name'], $data['Contact']['name']); // test that save occured
	}

/**
 * test Add With Activity method
 *
 * @return void
 */
	public function testAddWithActivity() {
		$data['Contact']['name'] = 'Fake Name';
		$data['Activity'][0]['model'] = 'Contact';
		$data['Activity'][0]['name'] = 'Made phone call';
		$data['Activity'][0]['description'] = 'Loreum ipsume dolo imar.';
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id), 'contain' => 'Activity'));
		
        $this->assertEqual($result['Contact']['name'], $data['Contact']['name']); // test that save occured
        $this->assertEqual($result['Activity'][0]['name'], $data['Activity'][0]['name']); // test that activity is included
	}
	
}
