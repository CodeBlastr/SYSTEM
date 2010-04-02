<?php 
/* SVN FILE: $Id$ */
/* QuoteTag Test cases generated on: 2009-12-14 00:58:32 : 1260770312*/
App::import('Model', 'QuoteTag');

class QuoteTagTestCase extends CakeTestCase {
	var $QuoteTag = null;
	var $fixtures = array('app.quote_tag', 'app.tag', 'app.quote');

	function startTest() {
		$this->QuoteTag =& ClassRegistry::init('QuoteTag');
	}

	function testQuoteTagInstance() {
		$this->assertTrue(is_a($this->QuoteTag, 'QuoteTag'));
	}

	function testQuoteTagFind() {
		$this->QuoteTag->recursive = -1;
		$results = $this->QuoteTag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('QuoteTag' => array(
			'id'  => 1,
			'tag_id'  => 1,
			'quote_id'  => 1,
			'created'  => '2009-12-14 00:58:32',
			'modified'  => '2009-12-14 00:58:32'
		));
		$this->assertEqual($results, $expected);
	}
}
?>