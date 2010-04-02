<?php 
/* SVN FILE: $Id$ */
/* PageUserGroup Test cases generated on: 2009-12-14 00:55:36 : 1260770136*/
App::import('Model', 'PageUserGroup');

class PageUserGroupTestCase extends CakeTestCase {
	var $PageUserGroup = null;
	var $fixtures = array('app.page_user_group', 'app.page', 'app.user_group');

	function startTest() {
		$this->PageUserGroup =& ClassRegistry::init('PageUserGroup');
	}

	function testPageUserGroupInstance() {
		$this->assertTrue(is_a($this->PageUserGroup, 'PageUserGroup'));
	}

	function testPageUserGroupFind() {
		$this->PageUserGroup->recursive = -1;
		$results = $this->PageUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('PageUserGroup' => array(
			'id'  => 1,
			'page_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:55:36',
			'modified'  => '2009-12-14 00:55:36'
		));
		$this->assertEqual($results, $expected);
	}
}
?>