<?php 
/* SVN FILE: $Id$ */
/* CampaignTextmessagesController Test cases generated on: 2009-12-13 23:17:30 : 1260764250*/
App::import('Controller', 'CampaignTextmessages');

class TestCampaignTextmessages extends CampaignTextmessagesController {
	var $autoRender = false;
}

class CampaignTextmessagesControllerTest extends CakeTestCase {
	var $CampaignTextmessages = null;

	function startTest() {
		$this->CampaignTextmessages = new TestCampaignTextmessages();
		$this->CampaignTextmessages->constructClasses();
	}

	function testCampaignTextmessagesControllerInstance() {
		$this->assertTrue(is_a($this->CampaignTextmessages, 'CampaignTextmessagesController'));
	}

	function endTest() {
		unset($this->CampaignTextmessages);
	}
}
?>