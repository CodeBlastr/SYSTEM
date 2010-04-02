<?php 
/* SVN FILE: $Id$ */
/* ContactSource Test cases generated on: 2010-01-09 21:54:53 : 1263092093*/
App::import('Model', 'ContactSource');

class ContactSourceTestCase extends CakeTestCase {
	var $ContactSource = null;
	var $fixtures = array('app.contact_source', 'app.contact');

	function startTest() {
		$this->ContactSource =& ClassRegistry::init('ContactSource');
	}

	function testContactSourceInstance() {
		$this->assertTrue(is_a($this->ContactSource, 'ContactSource'));
	}

	function testContactSourceFind() {
		$this->ContactSource->recursive = -1;
		$results = $this->ContactSource->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactSource' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-09 21:54:51',
			'modified'  => '2010-01-09 21:54:51'
		));
		$this->assertEqual($results, $expected);
	}
}
?>