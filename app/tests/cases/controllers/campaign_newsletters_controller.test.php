<?php 
/* SVN FILE: $Id$ */
/* CampaignNewslettersController Test cases generated on: 2009-12-13 23:17:42 : 1260764262*/
App::import('Controller', 'CampaignNewsletters');

class TestCampaignNewsletters extends CampaignNewslettersController {
	var $autoRender = false;
}

class CampaignNewslettersControllerTest extends CakeTestCase {
	var $CampaignNewsletters = null;

	function startTest() {
		$this->CampaignNewsletters = new TestCampaignNewsletters();
		$this->CampaignNewsletters->constructClasses();
	}

	function testCampaignNewslettersControllerInstance() {
		$this->assertTrue(is_a($this->CampaignNewsletters, 'CampaignNewslettersController'));
	}

	function endTest() {
		unset($this->CampaignNewsletters);
	}
}
?>