<?php 
/* SVN FILE: $Id$ */
/* ContactsRelationship Test cases generated on: 2010-01-03 21:30:07 : 1262572207*/
App::import('Model', 'ContactsRelationship');

class ContactsRelationshipTestCase extends CakeTestCase {
	var $ContactsRelationship = null;
	var $fixtures = array('app.contacts_relationship', 'app.contact_relationship_type', 'app.contact', 'app.related_contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactsRelationship =& ClassRegistry::init('ContactsRelationship');
	}

	function testContactsRelationshipInstance() {
		$this->assertTrue(is_a($this->ContactsRelationship, 'ContactsRelationship'));
	}

	function testContactsRelationshipFind() {
		$this->ContactsRelationship->recursive = -1;
		$results = $this->ContactsRelationship->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactsRelationship' => array(
			'id'  => 1,
			'contact_relationship_type_id'  => 1,
			'contact_id'  => 1,
			'related_contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 21:30:07',
			'modified'  => '2010-01-03 21:30:07'
		));
		$this->assertEqual($results, $expected);
	}
}
?>