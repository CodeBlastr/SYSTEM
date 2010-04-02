<?php 
/* SVN FILE: $Id$ */
/* ContactMedium Test cases generated on: 2009-12-14 00:38:18 : 1260769098*/
App::import('Model', 'ContactMedium');

class ContactMediumTestCase extends CakeTestCase {
	var $ContactMedium = null;
	var $fixtures = array('app.contact_medium', 'app.medium', 'app.contact');

	function startTest() {
		$this->ContactMedium =& ClassRegistry::init('ContactMedium');
	}

	function testContactMediumInstance() {
		$this->assertTrue(is_a($this->ContactMedium, 'ContactMedium'));
	}

	function testContactMediumFind() {
		$this->ContactMedium->recursive = -1;
		$results = $this->ContactMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'contact_id'  => 1,
			'created'  => '2009-12-14 00:38:18',
			'modified'  => '2009-12-14 00:38:18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>