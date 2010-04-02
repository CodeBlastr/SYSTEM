<?php 
/* SVN FILE: $Id$ */
/* CampaignAutoresponder Fixture generated on: 2009-12-13 23:59:52 : 1260766792*/

class CampaignAutoresponderFixture extends CakeTestFixture {
	var $name = 'CampaignAutoresponder';
	var $table = 'campaign_autoresponders';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'subject' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'content' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'text' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'delay' => array('type'=>'integer', 'null' => false, 'default' => '0'),
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
		'delay'  => 1,
		'user_id'  => 1,
		'campaign_id'  => 1,
		'created'  => '2009-12-13 23:59:52',
		'modified'  => '2009-12-13 23:59:52'
	));
}
?>