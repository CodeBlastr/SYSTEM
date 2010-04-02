<?php 
/* SVN FILE: $Id$ */
/* CampaignTextmessage Test cases generated on: 2009-12-14 00:00:58 : 1260766858*/
App::import('Model', 'CampaignTextmessage');

class CampaignTextmessageTestCase extends CakeTestCase {
	var $CampaignTextmessage = null;
	var $fixtures = array('app.campaign_textmessage', 'app.user', 'app.campaign');

	function startTest() {
		$this->CampaignTextmessage =& ClassRegistry::init('CampaignTextmessage');
	}

	function testCampaignTextmessageInstance() {
		$this->assertTrue(is_a($this->CampaignTextmessage, 'CampaignTextmessage'));
	}

	function testCampaignTextmessageFind() {
		$this->CampaignTextmessage->recursive = -1;
		$results = $this->CampaignTextmessage->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CampaignTextmessage' => array(
			'id'  => 1,
			'subject'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'send_date'  => '2009-12-14 00:00:58',
			'user_id'  => 1,
			'campaign_id'  => 1,
			'created'  => '2009-12-14 00:00:58',
			'modified'  => '2009-12-14 00:00:58'
		));
		$this->assertEqual($results, $expected);
	}
}
?>