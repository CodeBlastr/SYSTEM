<?php 
/* SVN FILE: $Id$ */
/* ContactDetailType Test cases generated on: 2009-12-14 00:37:36 : 1260769056*/
App::import('Model', 'ContactDetailType');

class ContactDetailTypeTestCase extends CakeTestCase {
	var $ContactDetailType = null;
	var $fixtures = array('app.contact_detail_type', 'app.contact_detail');

	function startTest() {
		$this->ContactDetailType =& ClassRegistry::init('ContactDetailType');
	}

	function testContactDetailTypeInstance() {
		$this->assertTrue(is_a($this->ContactDetailType, 'ContactDetailType'));
	}

	function testContactDetailTypeFind() {
		$this->ContactDetailType->recursive = -1;
		$results = $this->ContactDetailType->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactDetailType' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-12-14 00:37:36',
			'modified'  => '2009-12-14 00:37:36'
		));
		$this->assertEqual($results, $expected);
	}
}
?>