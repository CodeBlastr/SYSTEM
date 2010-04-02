<?php 
/* SVN FILE: $Id$ */
/* CampaignSubscribersController Test cases generated on: 2009-12-13 23:17:38 : 1260764258*/
App::import('Controller', 'CampaignSubscribers');

class TestCampaignSubscribers extends CampaignSubscribersController {
	var $autoRender = false;
}

class CampaignSubscribersControllerTest extends CakeTestCase {
	var $CampaignSubscribers = null;

	function startTest() {
		$this->CampaignSubscribers = new TestCampaignSubscribers();
		$this->CampaignSubscribers->constructClasses();
	}

	function testCampaignSubscribersControllerInstance() {
		$this->assertTrue(is_a($this->CampaignSubscribers, 'CampaignSubscribersController'));
	}

	function endTest() {
		unset($this->CampaignSubscribers);
	}
}
?>