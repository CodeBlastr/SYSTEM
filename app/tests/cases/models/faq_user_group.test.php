<?php 
/* SVN FILE: $Id$ */
/* FaqUserGroup Test cases generated on: 2009-12-14 00:45:15 : 1260769515*/
App::import('Model', 'FaqUserGroup');

class FaqUserGroupTestCase extends CakeTestCase {
	var $FaqUserGroup = null;
	var $fixtures = array('app.faq_user_group', 'app.faq_page', 'app.user_group');

	function startTest() {
		$this->FaqUserGroup =& ClassRegistry::init('FaqUserGroup');
	}

	function testFaqUserGroupInstance() {
		$this->assertTrue(is_a($this->FaqUserGroup, 'FaqUserGroup'));
	}

	function testFaqUserGroupFind() {
		$this->FaqUserGroup->recursive = -1;
		$results = $this->FaqUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('FaqUserGroup' => array(
			'id'  => 1,
			'faq_page_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:45:15',
			'modified'  => '2009-12-14 00:45:15'
		));
		$this->assertEqual($results, $expected);
	}
}
?>