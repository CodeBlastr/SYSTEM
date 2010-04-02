<?php 
/* SVN FILE: $Id$ */
/* Campaign Test cases generated on: 2009-12-14 00:01:59 : 1260766919*/
App::import('Model', 'Campaign');

class CampaignTestCase extends CakeTestCase {
	var $Campaign = null;
	var $fixtures = array('app.campaign', 'app.user', 'app.campaign_autoresponder', 'app.campaign_newsletter', 'app.campaign_subscriber', 'app.campaign_textmessage');

	function startTest() {
		$this->Campaign =& ClassRegistry::init('Campaign');
	}

	function testCampaignInstance() {
		$this->assertTrue(is_a($this->Campaign, 'Campaign'));
	}

	function testCampaignFind() {
		$this->Campaign->recursive = -1;
		$results = $this->Campaign->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Campaign' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'user_id'  => 1,
			'created'  => '2009-12-14 00:01:59',
			'modified'  => '2009-12-14 00:01:59'
		));
		$this->assertEqual($results, $expected);
	}
}
?>