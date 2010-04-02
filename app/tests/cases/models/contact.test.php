<?php 
/* SVN FILE: $Id$ */
/* Contact Test cases generated on: 2010-01-03 16:04:40 : 1262552680*/
App::import('Model', 'Contact');

class ContactTestCase extends CakeTestCase {
	var $Contact = null;
	var $fixtures = array('app.contact', 'app.contact_type', 'app.contact_source', 'app.contact_industry', 'app.contact_rating', 'app.owner', 'app.assignee', 'app.creator', 'app.modifier', 'app.contact_company', 'app.contact_person', 'app.user', 'app.contact_activity', 'app.contact_address', 'app.contact_detail', 'app.contact_task', 'app.invoice', 'app.order', 'app.project_issue', 'app.project', 'app.quote', 'app.ticket');

	function startTest() {
		$this->Contact =& ClassRegistry::init('Contact');
	}

	function testContactInstance() {
		$this->assertTrue(is_a($this->Contact, 'Contact'));
	}

	function testContactFind() {
		$this->Contact->recursive = -1;
		$results = $this->Contact->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Contact' => array(
			'id'  => 1,
			'contact_type_id'  => 1,
			'contact_source_id'  => 1,
			'contact_industry_id'  => 1,
			'contact_rating_id'  => 1,
			'owner_id'  => 1,
			'assignee_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 16:04:38',
			'modified'  => '2010-01-03 16:04:38'
		));
		$this->assertEqual($results, $expected);
	}
}
?>