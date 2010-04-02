<?php 
/* SVN FILE: $Id$ */
/* CampaignSubscriber Fixture generated on: 2009-12-14 00:00:39 : 1260766839*/

class CampaignSubscriberFixture extends CakeTestFixture {
	var $name = 'CampaignSubscriber';
	var $table = 'campaign_subscribers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'campaign_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'contact_id'  => 1,
		'campaign_id'  => 1,
		'user_id'  => 1,
		'created'  => '2009-12-14 00:00:39',
		'modified'  => '2009-12-14 00:00:39'
	));
}
?>