<?php 
/* SVN FILE: $Id$ */
/* QuoteMedium Test cases generated on: 2009-12-14 00:58:22 : 1260770302*/
App::import('Model', 'QuoteMedium');

class QuoteMediumTestCase extends CakeTestCase {
	var $QuoteMedium = null;
	var $fixtures = array('app.quote_medium', 'app.medium', 'app.quote');

	function startTest() {
		$this->QuoteMedium =& ClassRegistry::init('QuoteMedium');
	}

	function testQuoteMediumInstance() {
		$this->assertTrue(is_a($this->QuoteMedium, 'QuoteMedium'));
	}

	function testQuoteMediumFind() {
		$this->QuoteMedium->recursive = -1;
		$results = $this->QuoteMedium->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('QuoteMedium' => array(
			'id'  => 1,
			'medium_id'  => 1,
			'quote_id'  => 1,
			'created'  => '2009-12-14 00:58:22',
			'modified'  => '2009-12-14 00:58:22'
		));
		$this->assertEqual($results, $expected);
	}
}
?>