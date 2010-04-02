<?php 
/* SVN FILE: $Id$ */
/* CampaignsController Test cases generated on: 2009-12-13 23:17:53 : 1260764273*/
App::import('Controller', 'Campaigns');

class TestCampaigns extends CampaignsController {
	var $autoRender = false;
}

class CampaignsControllerTest extends CakeTestCase {
	var $Campaigns = null;

	function startTest() {
		$this->Campaigns = new TestCampaigns();
		$this->Campaigns->constructClasses();
	}

	function testCampaignsControllerInstance() {
		$this->assertTrue(is_a($this->Campaigns, 'CampaignsController'));
	}

	function endTest() {
		unset($this->Campaigns);
	}
}
?>