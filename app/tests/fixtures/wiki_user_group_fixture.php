<?php 
/* SVN FILE: $Id$ */
/* WikiUserGroup Fixture generated on: 2009-12-14 01:03:56 : 1260770636*/

class WikiUserGroupFixture extends CakeTestFixture {
	var $name = 'WikiUserGroup';
	var $table = 'wiki_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiki_page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'wiki_page_id'  => 1,
		'user_group_id'  => 1,
		'created'  => '2009-12-14 01:03:56',
		'modified'  => '2009-12-14 01:03:56'
	));
}
?>