<?php 
/* SVN FILE: $Id$ */
/* Ticket Test cases generated on: 2009-12-14 01:00:30 : 1260770430*/
App::import('Model', 'Ticket');

class TicketTestCase extends CakeTestCase {
	var $Ticket = null;
	var $fixtures = array('app.ticket', 'app.parent', 'app.ticket_type', 'app.user', 'app.assignedto', 'app.contact', 'app.ticket_medium', 'app.ticket_tag', 'app.ticket_user_group');

	function startTest() {
		$this->Ticket =& ClassRegistry::init('Ticket');
	}

	function testTicketInstance() {
		$this->assertTrue(is_a($this->Ticket, 'Ticket'));
	}

	function testTicketFind() {
		$this->Ticket->recursive = -1;
		$results = $this->Ticket->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Ticket' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'ticket_type_id'  => 1,
			'subject'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'user_id'  => 1,
			'assignedto_id'  => 1,
			'contact_id'  => 1,
			'created'  => '2009-12-14 01:00:30',
			'modified'  => '2009-12-14 01:00:30'
		));
		$this->assertEqual($results, $expected);
	}
}
?>