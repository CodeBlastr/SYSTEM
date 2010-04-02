<?php 
/* SVN FILE: $Id$ */
/* ContactDetail Test cases generated on: 2010-01-03 16:21:49 : 1262553709*/
App::import('Model', 'ContactDetail');

class ContactDetailTestCase extends CakeTestCase {
	var $ContactDetail = null;
	var $fixtures = array('app.contact_detail', 'app.contact_detail_type', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactDetail =& ClassRegistry::init('ContactDetail');
	}

	function testContactDetailInstance() {
		$this->assertTrue(is_a($this->ContactDetail, 'ContactDetail'));
	}

	function testContactDetailFind() {
		$this->ContactDetail->recursive = -1;
		$results = $this->ContactDetail->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactDetail' => array(
			'id'  => 1,
			'contact_detail_type_id'  => 1,
			'value'  => 'Lorem ipsum dolor sit amet',
			'default'  => 1,
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 16:21:48',
			'modified'  => '2010-01-03 16:21:48'
		));
		$this->assertEqual($results, $expected);
	}
}
?>