<?php 
/* SVN FILE: $Id$ */
/* ContactType Test cases generated on: 2010-01-09 21:53:45 : 1263092025*/
App::import('Model', 'ContactType');

class ContactTypeTestCase extends CakeTestCase {
	var $ContactType = null;
	var $fixtures = array('app.contact_type', 'app.contact');

	function startTest() {
		$this->ContactType =& ClassRegistry::init('ContactType');
	}

	function testContactTypeInstance() {
		$this->assertTrue(is_a($this->ContactType, 'ContactType'));
	}

	function testContactTypeFind() {
		$this->ContactType->recursive = -1;
		$results = $this->ContactType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-09 21:53:44',
			'modified'  => '2010-01-09 21:53:44'
		));
		$this->assertEqual($results, $expected);
	}
}
?>