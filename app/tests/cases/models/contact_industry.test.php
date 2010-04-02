<?php 
/* SVN FILE: $Id$ */
/* ContactIndustry Test cases generated on: 2010-01-09 21:55:33 : 1263092133*/
App::import('Model', 'ContactIndustry');

class ContactIndustryTestCase extends CakeTestCase {
	var $ContactIndustry = null;
	var $fixtures = array('app.contact_industry', 'app.contact');

	function startTest() {
		$this->ContactIndustry =& ClassRegistry::init('ContactIndustry');
	}

	function testContactIndustryInstance() {
		$this->assertTrue(is_a($this->ContactIndustry, 'ContactIndustry'));
	}

	function testContactIndustryFind() {
		$this->ContactIndustry->recursive = -1;
		$results = $this->ContactIndustry->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactIndustry' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-09 21:55:33',
			'modified'  => '2010-01-09 21:55:33'
		));
		$this->assertEqual($results, $expected);
	}
}
?>