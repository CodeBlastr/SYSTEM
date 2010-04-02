<?php 
/* SVN FILE: $Id$ */
/* ContactsTag Test cases generated on: 2010-01-05 21:22:20 : 1262744540*/
App::import('Model', 'ContactsTag');

class ContactsTagTestCase extends CakeTestCase {
	var $ContactsTag = null;
	var $fixtures = array('app.contacts_tag', 'app.tag', 'app.contact');

	function startTest() {
		$this->ContactsTag =& ClassRegistry::init('ContactsTag');
	}

	function testContactsTagInstance() {
		$this->assertTrue(is_a($this->ContactsTag, 'ContactsTag'));
	}

	function testContactsTagFind() {
		$this->ContactsTag->recursive = -1;
		$results = $this->ContactsTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactsTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'contact_id'  => 1,
			'created'  => '2010-01-05 21:22:20',
			'modified'  => '2010-01-05 21:22:20'
		));
		$this->assertEqual($results, $expected);
	}
}
?>