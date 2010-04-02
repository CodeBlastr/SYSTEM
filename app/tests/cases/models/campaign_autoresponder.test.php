<?php 
/* SVN FILE: $Id$ */
/* CampaignAutoresponder Test cases generated on: 2009-12-13 23:59:52 : 1260766792*/
App::import('Model', 'CampaignAutoresponder');

class CampaignAutoresponderTestCase extends CakeTestCase {
	var $CampaignAutoresponder = null;
	var $fixtures = array('app.campaign_autoresponder', 'app.user', 'app.campaign');

	function startTest() {
		$this->CampaignAutoresponder =& ClassRegistry::init('CampaignAutoresponder');
	}

	function testCampaignAutoresponderInstance() {
		$this->assertTrue(is_a($this->CampaignAutoresponder, 'CampaignAutoresponder'));
	}

	function testCampaignAutoresponderFind() {
		$this->CampaignAutoresponder->recursive = -1;
		$results = $this->CampaignAutoresponder->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CampaignAutoresponder' => array(
			'id'  => 1,
			'subject'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'delay'  => 1,
			'user_id'  => 1,
			'campaign_id'  => 1,
			'created'  => '2009-12-13 23:59:52',
			'modified'  => '2009-12-13 23:59:52'
		));
		$this->assertEqual($results, $expected);
	}
}
?>