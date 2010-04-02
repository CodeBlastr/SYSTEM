<?php 
/* SVN FILE: $Id$ */
/* QuoteItem Test cases generated on: 2009-12-14 00:58:14 : 1260770294*/
App::import('Model', 'QuoteItem');

class QuoteItemTestCase extends CakeTestCase {
	var $QuoteItem = null;
	var $fixtures = array('app.quote_item', 'app.user', 'app.quote_item_relationship');

	function startTest() {
		$this->QuoteItem =& ClassRegistry::init('QuoteItem');
	}

	function testQuoteItemInstance() {
		$this->assertTrue(is_a($this->QuoteItem, 'QuoteItem'));
	}

	function testQuoteItemFind() {
		$this->QuoteItem->recursive = -1;
		$results = $this->QuoteItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('QuoteItem' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'price'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'user_id'  => 1,
			'created'  => '2009-12-14 00:58:14',
			'modified'  => '2009-12-14 00:58:14'
		));
		$this->assertEqual($results, $expected);
	}
}
?>