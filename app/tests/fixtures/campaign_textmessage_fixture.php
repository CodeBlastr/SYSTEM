<?php 
/* SVN FILE: $Id$ */
/* CampaignTextmessage Fixture generated on: 2009-12-14 00:00:58 : 1260766858*/

class CampaignTextmessageFixture extends CakeTestFixture {
	var $name = 'CampaignTextmessage';
	var $table = 'campaign_textmessages';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'subject' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'content' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'text' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'send_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'campaign_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>