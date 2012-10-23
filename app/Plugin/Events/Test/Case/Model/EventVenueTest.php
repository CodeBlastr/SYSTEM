<?php
App::uses('EventVenue', 'Events.Model');

/**
 * EventVenue Test Case
 *
 */
class EventVenueTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.events.event_venue', 'app.event', 'app.creator', 'app.modifier', 'app.event_guest', 'app.event_seat');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EventVenue = ClassRegistry::init('EventVenue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EventVenue);

		parent::tearDown();
	}

}
