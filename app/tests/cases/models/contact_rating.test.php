<?php 
/* SVN FILE: $Id$ */
/* ContactRating Test cases generated on: 2010-01-09 21:55:54 : 1263092154*/
App::import('Model', 'ContactRating');

class ContactRatingTestCase extends CakeTestCase {
	var $ContactRating = null;
	var $fixtures = array('app.contact_rating', 'app.contact');

	function startTest() {
		$this->ContactRating =& ClassRegistry::init('ContactRating');
	}

	function testContactRatingInstance() {
		$this->assertTrue(is_a($this->ContactRating, 'ContactRating'));
	}

	function testContactRatingFind() {
		$this->ContactRating->recursive = -1;
		$results = $this->ContactRating->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ContactRating' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-01-09 21:55:53',
			'modified'  => '2010-01-09 21:55:53'
		));
		$this->assertEqual($results, $expected);
	}
}
?>