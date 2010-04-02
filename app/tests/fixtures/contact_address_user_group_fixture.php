<?php 
/* SVN FILE: $Id$ */
/* ContactAddressUserGroup Fixture generated on: 2009-12-14 00:34:50 : 1260768890*/

class ContactAddressUserGroupFixture extends CakeTestFixture {
	var $name = 'ContactAddressUserGroup';
	var $table = 'contact_address_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_address_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_group_id'  => 1,
		'contact_address_id'  => 1,
		'created'  => '2009-12-14 00:34:50',
		'modified'  => '2009-12-14 00:34:50'
	));
}
?>