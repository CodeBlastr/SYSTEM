<?php 
/* SVN FILE: $Id$ */
/* Quote Test cases generated on: 2009-12-14 00:58:59 : 1260770339*/
App::import('Model', 'Quote');

class QuoteTestCase extends CakeTestCase {
	var $Quote = null;
	var $fixtures = array('app.quote', 'app.user', 'app.contact', 'app.quote_item_relationship', 'app.quote_medium', 'app.quote_tag', 'app.quote_user_group');

	function startTest() {
		$this->Quote =& ClassRegistry::init('Quote');
	}

	function testQuoteInstance() {
		$this->assertTrue(is_a($this->Quote, 'Quote'));
	}

	function testQuoteFind() {
		$this->Quote->recursive = -1;
		$results = $this->Quote->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Quote' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'conclusion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'sendto'  => 'Lorem ipsum dolor sit amet',
			'start_date'  => '2009-12-14 00:58:59',
			'end_date'  => '2009-12-14 00:58:59',
			'published'  => 1,
			'user_id'  => 1,
			'contact_id'  => 1,
			'created'  => '2009-12-14 00:58:59',
			'modified'  => '2009-12-14 00:58:59'
		));
		$this->assertEqual($results, $expected);
	}
}
?>