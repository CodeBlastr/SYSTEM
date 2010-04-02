<?php 
/* SVN FILE: $Id$ */
/* CampaignSubscriber Test cases generated on: 2009-12-14 00:00:39 : 1260766839*/
App::import('Model', 'CampaignSubscriber');

class CampaignSubscriberTestCase extends CakeTestCase {
	var $CampaignSubscriber = null;
	var $fixtures = array('app.campaign_subscriber', 'app.contact', 'app.campaign', 'app.user');

	function startTest() {
		$this->CampaignSubscriber =& ClassRegistry::init('CampaignSubscriber');
	}

	function testCampaignSubscriberInstance() {
		$this->assertTrue(is_a($this->CampaignSubscriber, 'CampaignSubscriber'));
	}

	function testCampaignSubscriberFind() {
		$this->CampaignSubscriber->recursive = -1;
		$results = $this->CampaignSubscriber->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CampaignSubscriber' => array(
			'id'  => 1,
			'contact_id'  => 1,
			'campaign_id'  => 1,
			'user_id'  => 1,
			'created'  => '2009-12-14 00:00:39',
			'modified'  => '2009-12-14 00:00:39'
		));
		$this->assertEqual($results, $expected);
	}
}
?>