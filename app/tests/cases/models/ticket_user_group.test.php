<?php 
/* SVN FILE: $Id$ */
/* TicketUserGroup Test cases generated on: 2009-12-14 01:00:14 : 1260770414*/
App::import('Model', 'TicketUserGroup');

class TicketUserGroupTestCase extends CakeTestCase {
	var $TicketUserGroup = null;
	var $fixtures = array('app.ticket_user_group', 'app.ticket', 'app.user_group');

	function startTest() {
		$this->TicketUserGroup =& ClassRegistry::init('TicketUserGroup');
	}

	function testTicketUserGroupInstance() {
		$this->assertTrue(is_a($this->TicketUserGroup, 'TicketUserGroup'));
	}

	function testTicketUserGroupFind() {
		$this->TicketUserGroup->recursive = -1;
		$results = $this->TicketUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TicketUserGroup' => array(
			'id'  => 1,
			'ticket_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 01:00:14',
			'modified'  => '2009-12-14 01:00:14'
		));
		$this->assertEqual($results, $expected);
	}
}
?>