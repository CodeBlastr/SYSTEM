<?php 
/* SVN FILE: $Id$ */
/* ContactCompany Test cases generated on: 2010-01-03 21:45:07 : 1262573107*/
App::import('Model', 'ContactCompany');

class ContactCompanyTestCase extends CakeTestCase {
	var $ContactCompany = null;
	var $fixtures = array('app.contact_company', 'app.contact', 'app.creator', 'app.modifier');

	function startTest() {
		$this->ContactCompany =& ClassRegistry::init('ContactCompany');
	}

	function testContactCompanyInstance() {
		$this->assertTrue(is_a($this->ContactCompany, 'ContactCompany'));
	}

	function testContactCompanyFind() {
		$this->ContactCompany->recursive = -1;
		$results = $this->ContactCompany->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactCompany' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'contact_id'  => 1,
			'creator_id'  => 1,
			'modifier_id'  => 1,
			'created'  => '2010-01-03 21:45:05',
			'modified'  => '2010-01-03 21:45:05'
		));
		$this->assertEqual($results, $expected);
	}
}
?>