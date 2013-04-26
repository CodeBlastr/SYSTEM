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
		'plugin.Contacts.Contact',
		'plugin.Contacts.ContactDetail', // gotta make sure the fixture file exists, not just the config schema!!!
        'plugin.Activities.Activity',
        'plugin.Tasks.Task',
        'plugin.Estimates.Estimate',
        );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contact = ClassRegistry::init('Contacts.Contact');
		$this->Activity = ClassRegistry::init('Activities.Activity');
		$this->Task = ClassRegistry::init('Tasks.Task');
		$this->Estimate = ClassRegistry::init('Estimates.Estimate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contact);
		unset($this->Activity);
		unset($this->Task);
		unset($this->Estimate);

		parent::tearDown();
	}

/**
 * test Add method
 *
 * @return void
 */
	public function testAdd() {
		$data['Contact']['name'] = 'Fake Name';
		$data['Contact']['contact_type'] = 'lead';
		$data['Contact']['contact_rating'] = 'hot';
		$data['Contact']['contact_source'] = 'form';
		$data['Contact']['contact_industry'] = 'construction';
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id)));
		
        $this->assertEqual($result['Contact']['name'], $data['Contact']['name']); // test that save occured
        $this->assertEqual($result['Contact']['contact_type'], $data['Contact']['contact_type']); // test that meta fields work
        $this->assertEqual($result['Contact']['contact_rating'], $data['Contact']['contact_rating']); // test that meta fields work
        $this->assertEqual($result['Contact']['contact_source'], $data['Contact']['contact_source']); // test that meta fields work
        $this->assertEqual($result['Contact']['contact_industry'], $data['Contact']['contact_industry']); // test that meta fields work
	}

/**
 * test Add With Activity method
 *
 * @return void
 */
	public function testAddWithActivity() {
		$data['Contact']['name'] = 'Fake Name';
		$data['Activity'][0]['model'] = 'Contact';
		$data['Activity'][0]['action_description'] = 'contact activity';
		$data['Activity'][0]['name'] = 'Made phone call';
		$data['Activity'][0]['description'] = 'Loreum ipsume dolo imar.';
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id), 'contain' => 'Activity'));
		
        $this->assertEqual($result['Contact']['name'], $data['Contact']['name']); // test that save occured
        $this->assertEqual($result['Activity'][0]['name'], $data['Activity'][0]['name']); // test that activity is included
	}

/**
 * test Add With Task method
 *
 * @return void
 */
	public function testAddWithTask() {
		$data['Contact']['name'] = 'Fake Name';
		$data['Task'][0]['model'] = 'Contact';
		$data['Task'][0]['name'] = 'Call back';
		$data['Task'][0]['description'] = 'Loreum ipsume dolo imar.';
		$data['Task'][0]['assignee_id'] = 33;
		$data['Task'][0]['due_date'] = '2012-10-30';
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id), 'contain' => 'Task'));
		
        $this->assertEqual($result['Contact']['name'], $data['Contact']['name']); // test that save occured
        $this->assertEqual($result['Task'][0]['name'], $data['Task'][0]['name'] . ' ' . $data['Contact']['name']); // test that task is included with contact name added
	}

/**
 * test Add With Estimate method
 *
 * @return void
 */
	public function testAddWithEstimate() {
		$data['Contact']['name'] = 'Fake Name';
		$data['Estimate'][0]['model'] = 'Contact';
		$data['Estimate'][0]['total'] = '5000.00';
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id), 'contain' => 'Estimate'));
		
        $this->assertEqual($result['Contact']['name'], $data['Contact']['name']); // test that save occured
        $this->assertEqual($result['Estimate'][0]['total'], $data['Estimate'][0]['total']); // test that activity is included
	}

/**
 * test Add With Estimate method
 *
 * @return void
 */
	public function testAddWithLoggableLead() {
		$data['Contact']['name'] = 'Fake Name';
		$data['Contact']['contact_type'] = 'lead';
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id), 'contain' => 'Activity'));
		
        $this->assertEqual($result['Activity'][0]['foreign_key'], $this->Contact->id); // test that lead adding is logged
	}

/**
 * test Add With Task method
 *
 * @return void
 */
	public function testAddWithAll() {
		$data['Contact']['name'] = 'Fake Name';
		$data['Contact']['is_company'] = 1;
		$data['Contact']['contact_type'] = 'lead';
		$data['Contact']['contact_rating'] = 'hot';
		
		$data['ContactDetail'][0]['contact_detail_type'] = 'email';
		$data['ContactDetail'][0]['value'] = 'test@example.com';
		
		$data['Estimate'][0]['model'] = 'Contact';
		$data['Estimate'][0]['total'] = '5000.00';
		$data['Estimate'][0]['description'] = 'Loreum ipsum dolo mar.';
		
		$data['Activity'][0]['model'] = 'Contact';
		$data['Activity'][0]['action_description'] = 'contact activity';
		$data['Activity'][0]['name'] = 'Made phone call';
		$data['Activity'][0]['description'] = 'Loreum ipsum dolo mar.';
		
		$data['Task'][0]['model'] = 'Contact';
		$data['Task'][0]['name'] = 'Call back';
		$data['Task'][0]['description'] = 'Loreum ipsume dolo mar.';
		$data['Task'][0]['assignee_id'] = 33;
		$data['Task'][0]['due_date'] = '2012-10-30';
		
		$this->Contact->add($data);
		$result = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Contact->id), 'contain' => array('Activity', 'Estimate', 'ContactDetail', 'Task')));
				
        $this->assertEqual($result['Contact']['name'], $data['Contact']['name']); // test that save occured
        $this->assertEqual($result['Task'][0]['name'], $data['Task'][0]['name']); // test that task is included
        $this->assertEqual($result['Estimate'][0]['total'], $data['Estimate'][0]['total']); // test that estimate is included
        $this->assertEqual($result['Activity'][0]['name'], $data['Contact']['name']); // test that activity is included
        $this->assertEqual($result['Activity'][1]['name'], $data['Activity'][0]['name']); // test that activity is included
	}
	
}
