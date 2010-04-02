<?php 
/* SVN FILE: $Id$ */
/* TicketTag Test cases generated on: 2009-12-14 00:59:56 : 1260770396*/
App::import('Model', 'TicketTag');

class TicketTagTestCase extends CakeTestCase {
	var $TicketTag = null;
	var $fixtures = array('app.ticket_tag', 'app.tag', 'app.ticket');

	function startTest() {
		$this->TicketTag =& ClassRegistry::init('TicketTag');
	}

	function testTicketTagInstance() {
		$this->assertTrue(is_a($this->TicketTag, 'TicketTag'));
	}

	function testTicketTagFind() {
		$this->TicketTag->recursive = -1;
		$results = $this->TicketTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TicketTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'ticket_id'  => 1,
			'created'  => '2009-12-14 00:59:56',
			'modified'  => '2009-12-14 00:59:56'
		));
		$this->assertEqual($results, $expected);
	}
}
?>