<?php 
/* SVN FILE: $Id$ */
/* TicketMedium Test cases generated on: 2009-12-14 00:59:47 : 1260770387*/
App::import('Model', 'TicketMedium');

class TicketMediumTestCase extends CakeTestCase {
	var $TicketMedium = null;
	var $fixtures = array('app.ticket_medium', 'app.medium', 'app.ticket');

	function startTest() {
		$this->TicketMedium =& ClassRegistry::init('TicketMedium');
	}

	function testTicketMediumInstance() {
		$this->assertTrue(is_a($this->TicketMedium, 'TicketMedium'));
	}

	function testTicketMediumFind() {
		$this->TicketMedium->recursive = -1;
		$results = $this->TicketMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TicketMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'ticket_id'  => 1,
			'created'  => '2009-12-14 00:59:47',
			'modified'  => '2009-12-14 00:59:47'
		));
		$this->assertEqual($results, $expected);
	}
}
?>