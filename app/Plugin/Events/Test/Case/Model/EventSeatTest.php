<?php
App::uses('EventSeat', 'Events.Model');

/**
 * EventSeat Test Case
 *
 */
class EventSeatTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.events.event_seat', 'app.event_venue', 'app.creator', 'app.modifier', 'app.event_guest');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EventSeat = ClassRegistry::init('EventSeat');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EventSeat);

		parent::tearDown();
	}

}
