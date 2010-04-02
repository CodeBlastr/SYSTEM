<?php 
/* SVN FILE: $Id$ */
/* TicketType Test cases generated on: 2009-12-14 01:00:06 : 1260770406*/
App::import('Model', 'TicketType');

class TicketTypeTestCase extends CakeTestCase {
	var $TicketType = null;
	var $fixtures = array('app.ticket_type', 'app.ticket');

	function startTest() {
		$this->TicketType =& ClassRegistry::init('TicketType');
	}

	function testTicketTypeInstance() {
		$this->assertTrue(is_a($this->TicketType, 'TicketType'));
	}

	function testTicketTypeFind() {
		$this->TicketType->recursive = -1;
		$results = $this->TicketType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TicketType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 01:00:06',
			'modified'  => '2009-12-14 01:00:06'
		));
		$this->assertEqual($results, $expected);
	}
}
?>