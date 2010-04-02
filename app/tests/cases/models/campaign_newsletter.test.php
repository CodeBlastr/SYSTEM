<?php 
/* SVN FILE: $Id$ */
/* CampaignNewsletter Test cases generated on: 2009-12-14 00:00:12 : 1260766812*/
App::import('Model', 'CampaignNewsletter');

class CampaignNewsletterTestCase extends CakeTestCase {
	var $CampaignNewsletter = null;
	var $fixtures = array('app.campaign_newsletter', 'app.user', 'app.campaign');

	function startTest() {
		$this->CampaignNewsletter =& ClassRegistry::init('CampaignNewsletter');
	}

	function testCampaignNewsletterInstance() {
		$this->assertTrue(is_a($this->CampaignNewsletter, 'CampaignNewsletter'));
	}

	function testCampaignNewsletterFind() {
		$this->CampaignNewsletter->recursive = -1;
		$results = $this->CampaignNewsletter->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CampaignNewsletter' => array(
			'id'  => 1,
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'delay'  => 1,
			'user_id'  => 1,
			'campaign_id'  => 1,
			'created'  => '2009-12-14 00:00:12',
			'modified'  => '2009-12-14 00:00:12'
		));
		$this->assertEqual($results, $expected);
	}
}
?>