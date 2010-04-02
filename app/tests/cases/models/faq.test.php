<?php 
/* SVN FILE: $Id$ */
/* Faq Test cases generated on: 2009-12-14 00:45:33 : 1260769533*/
App::import('Model', 'Faq');

class FaqTestCase extends CakeTestCase {
	var $Faq = null;
	var $fixtures = array('app.faq', 'app.user', 'app.faq_page');

	function startTest() {
		$this->Faq =& ClassRegistry::init('Faq');
	}

	function testFaqInstance() {
		$this->assertTrue(is_a($this->Faq, 'Faq'));
	}

	function testFaqFind() {
		$this->Faq->recursive = -1;
		$results = $this->Faq->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Faq' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'public'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-14 00:45:33',
			'modified'  => '2009-12-14 00:45:33'
		));
		$this->assertEqual($results, $expected);
	}
}
?>