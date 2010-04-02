<?php 
/* SVN FILE: $Id$ */
/* ContactTag Test cases generated on: 2009-12-14 00:39:33 : 1260769173*/
App::import('Model', 'ContactTag');

class ContactTagTestCase extends CakeTestCase {
	var $ContactTag = null;
	var $fixtures = array('app.contact_tag', 'app.tag', 'app.contact');

	function startTest() {
		$this->ContactTag =& ClassRegistry::init('ContactTag');
	}

	function testContactTagInstance() {
		$this->assertTrue(is_a($this->ContactTag, 'ContactTag'));
	}

	function testContactTagFind() {
		$this->ContactTag->recursive = -1;
		$results = $this->ContactTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'contact_id'  => 1,
			'created'  => '2009-12-14 00:39:33',
			'modified'  => '2009-12-14 00:39:33'
		));
		$this->assertEqual($results, $expected);
	}
}
?>