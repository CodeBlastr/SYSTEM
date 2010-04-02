<?php 
/* SVN FILE: $Id$ */
/* ContactPersonSalutation Test cases generated on: 2009-12-16 16:17:49 : 1260998269*/
App::import('Model', 'ContactPersonSalutation');

class ContactPersonSalutationTestCase extends CakeTestCase {
	var $ContactPersonSalutation = null;
	var $fixtures = array('app.contact_person_salutation', 'app.contact_person');

	function startTest() {
		$this->ContactPersonSalutation =& ClassRegistry::init('ContactPersonSalutation');
	}

	function testContactPersonSalutationInstance() {
		$this->assertTrue(is_a($this->ContactPersonSalutation, 'ContactPersonSalutation'));
	}

	function testContactPersonSalutationFind() {
		$this->ContactPersonSalutation->recursive = -1;
		$results = $this->ContactPersonSalutation->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactPersonSalutation' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-16 16:17:48',
			'modified'  => '2009-12-16 16:17:48'
		));
		$this->assertEqual($results, $expected);
	}
}
?>