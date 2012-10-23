<?php
App::uses('EventSchedule', 'Events.Model');

/**
 * EventSchedule Test Case
 *
 */
class EventScheduleTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.events.event_schedule', 'app.type', 'app.creator', 'app.modifier', 'app.event');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EventSchedule = ClassRegistry::init('EventSchedule');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EventSchedule);

		parent::tearDown();
	}

}
