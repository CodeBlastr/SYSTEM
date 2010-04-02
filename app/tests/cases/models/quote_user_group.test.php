<?php 
/* SVN FILE: $Id$ */
/* QuoteUserGroup Test cases generated on: 2009-12-14 00:58:42 : 1260770322*/
App::import('Model', 'QuoteUserGroup');

class QuoteUserGroupTestCase extends CakeTestCase {
	var $QuoteUserGroup = null;
	var $fixtures = array('app.quote_user_group', 'app.quote', 'app.user_group');

	function startTest() {
		$this->QuoteUserGroup =& ClassRegistry::init('QuoteUserGroup');
	}

	function testQuoteUserGroupInstance() {
		$this->assertTrue(is_a($this->QuoteUserGroup, 'QuoteUserGroup'));
	}

	function testQuoteUserGroupFind() {
		$this->QuoteUserGroup->recursive = -1;
		$results = $this->QuoteUserGroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('QuoteUserGroup' => array(
			'id'  => 1,
			'quote_id'  => 1,
			'user_group_id'  => 1,
			'created'  => '2009-12-14 00:58:42',
			'modified'  => '2009-12-14 00:58:42'
		));
		$this->assertEqual($results, $expected);
	}
}
?>