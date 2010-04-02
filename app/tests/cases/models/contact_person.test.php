<?php 
/* SVN FILE: $Id$ */
/* ContactPerson Test cases generated on: 2010-01-03 16:23:31 : 1262553811*/
App::import('Model', 'ContactPerson');

class ContactPersonTestCase extends CakeTestCase {
	var $ContactPerson = null;
	var $fixtures = array('app.contact_person', 'app.contact_person_salutation', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactPerson =& ClassRegistry::init('ContactPerson');
	}

	function testContactPersonInstance() {
		$this->assertTrue(is_a($this->ContactPerson, 'ContactPerson'));
	}

	function testContactPersonFind() {
		$this->ContactPerson->recursive = -1;
		$results = $this->ContactPerson->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactPerson' => array(
			'id'  => 1,
			'contact_person_salutation_id'  => 1,
			'first_name'  => 'Lorem ipsum dolor sit amet',
			'last_name'  => 'Lorem ipsum dolor sit amet',
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 16:23:30',
			'modified'  => '2010-01-03 16:23:30'
		));
		$this->assertEqual($results, $expected);
	}
}
?>