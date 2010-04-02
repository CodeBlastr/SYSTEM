<?php 
/* SVN FILE: $Id$ */
/* CampaignAutorespondersController Test cases generated on: 2009-12-13 23:17:48 : 1260764268*/
App::import('Controller', 'CampaignAutoresponders');

class TestCampaignAutoresponders extends CampaignAutorespondersController {
	var $autoRender = false;
}

class CampaignAutorespondersControllerTest extends CakeTestCase {
	var $CampaignAutoresponders = null;

	function startTest() {
		$this->CampaignAutoresponders = new TestCampaignAutoresponders();
		$this->CampaignAutoresponders->constructClasses();
	}

	function testCampaignAutorespondersControllerInstance() {
		$this->assertTrue(is_a($this->CampaignAutoresponders, 'CampaignAutorespondersController'));
	}

	function endTest() {
		unset($this->CampaignAutoresponders);
	}
}
?>