<?php 
/* SVN FILE: $Id$ */
/* FaqUserGroup Fixture generated on: 2009-12-14 00:45:15 : 1260769515*/

class FaqUserGroupFixture extends CakeTestFixture {
	var $name = 'FaqUserGroup';
	var $table = 'faq_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'faq_page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'faq_page_id'  => 1,
		'user_group_id'  => 1,
		'created'  => '2009-12-14 00:45:15',
		'modified'  => '2009-12-14 00:45:15'
	));
}
?>