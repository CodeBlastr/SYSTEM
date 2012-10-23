<?php
App::uses('EventGuest', 'Events.Model');

/**
 * EventGuest Test Case
 *
 */
class EventGuestTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.events.event_guest', 'app.event', 'app.user', 'app.event_venue', 'app.event_seat', 'app.creator', 'app.modifier');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EventGuest = ClassRegistry::init('EventGuest');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EventGuest);

		parent::tearDown();
	}

}
