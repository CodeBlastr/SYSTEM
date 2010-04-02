<?php 
/* SVN FILE: $Id$ */
/* MediumUserGroup Test cases generated on: 2009-12-14 00:51:51 : 1260769911*/
App::import('Model', 'MediumUserGroup');

class MediumUserGroupTestCase extends CakeTestCase {
	var $MediumUserGroup = null;
	var $fixtures = array('app.medium_user_group', 'app.user_group', 'app.media');

	function startTest() {
		$this->MediumUserGroup =& ClassRegistry::init('MediumUserGroup');
	}

	function testMediumUserGroupInstance() {
		$this->assertTrue(is_a($this->MediumUserGroup, 'MediumUserGroup'));
	}

	function testMediumUserGroupFind() {
		$this->MediumUserGroup->recursive = -1;
		$results = $this->MediumUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('MediumUserGroup' => array(
			'id'  => 1,
			'user_group_id'  => 1,
			'media_id'  => 1,
			'created'  => '2009-12-14 00:51:51',
			'modified'  => '2009-12-14 00:51:51'
		));
		$this->assertEqual($results, $expected);
	}
}
?>