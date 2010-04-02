<?php 
/* SVN FILE: $Id$ */
/* ContactRelationship Test cases generated on: 2009-12-19 14:49:48 : 1261252188*/
App::import('Model', 'ContactRelationship');

class ContactRelationshipTestCase extends CakeTestCase {
	var $ContactRelationship = null;
	var $fixtures = array('app.contact_relationship', 'app.contact_relationship_type', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactRelationship =& ClassRegistry::init('ContactRelationship');
	}

	function testContactRelationshipInstance() {
		$this->assertTrue(is_a($this->ContactRelationship, 'ContactRelationship'));
	}

	function testContactRelationshipFind() {
		$this->ContactRelationship->recursive = -1;
		$results = $this->ContactRelationship->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactRelationship' => array(
			'id'  => 1,
			'contact_relationship_type_id'  => 1,
			'contact_id'  => 1,
			'related_contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2009-12-19 14:49:47',
			'modified'  => '2009-12-19 14:49:47'
		));
		$this->assertEqual($results, $expected);
	}
}
?>