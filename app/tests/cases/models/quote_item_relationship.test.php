<?php 
/* SVN FILE: $Id$ */
/* QuoteItemRelationship Test cases generated on: 2009-12-14 00:58:04 : 1260770284*/
App::import('Model', 'QuoteItemRelationship');

class QuoteItemRelationshipTestCase extends CakeTestCase {
	var $QuoteItemRelationship = null;
	var $fixtures = array('app.quote_item_relationship', 'app.user', 'app.quote', 'app.quote_item');

	function startTest() {
		$this->QuoteItemRelationship =& ClassRegistry::init('QuoteItemRelationship');
	}

	function testQuoteItemRelationshipInstance() {
		$this->assertTrue(is_a($this->QuoteItemRelationship, 'QuoteItemRelationship'));
	}

	function testQuoteItemRelationshipFind() {
		$this->QuoteItemRelationship->recursive = -1;
		$results = $this->QuoteItemRelationship->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('QuoteItemRelationship' => array(
			'id'  => 1,
			'user_id'  => 1,
			'quote_id'  => 1,
			'quote_item_id'  => 1,
			'created'  => '2009-12-14 00:58:04',
			'modified'  => '2009-12-14 00:58:04'
		));
		$this->assertEqual($results, $expected);
	}
}
?>