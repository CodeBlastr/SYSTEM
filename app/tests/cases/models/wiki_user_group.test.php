<?php 
/* SVN FILE: $Id$ */
/* WikiUserGroup Test cases generated on: 2009-12-14 01:03:56 : 1260770636*/
App::import('Model', 'WikiUserGroup');

class WikiUserGroupTestCase extends CakeTestCase {
	var $WikiUserGroup = null;
	var $fixtures = array('app.wiki_user_group', 'app.wiki_page', 'app.user_group');

	function startTest() {
		$this->WikiUserGroup =& ClassRegistry::init('WikiUserGroup');
	}

	function testWikiUserGroupInstance() {
		$this->assertTrue(is_a($this->WikiUserGroup, 'WikiUserGroup'));
	}

	function testWikiUserGroupFind() {
		$this->WikiUserGroup->recursive = -1;
		$results = $this->WikiUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('WikiUserGroup' => array(
			'id'  => 1,
			'wiki_page_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 01:03:56',
			'modified'  => '2009-12-14 01:03:56'
		));
		$this->assertEqual($results, $expected);
	}
}
?>