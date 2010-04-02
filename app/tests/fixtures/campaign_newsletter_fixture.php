<?php 
/* SVN FILE: $Id$ */
/* CampaignNewsletter Fixture generated on: 2009-12-14 00:00:12 : 1260766812*/

class CampaignNewsletterFixture extends CakeTestFixture {
	var $name = 'CampaignNewsletter';
	var $table = 'campaign_newsletters';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'content' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'delay' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'campaign_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'delay'  => 1,
		'user_id'  => 1,
		'campaign_id'  => 1,
		'created'  => '2009-12-14 00:00:12',
		'modified'  => '2009-12-14 00:00:12'
	));
}
?>