<?php 
/* SVN FILE: $Id$ */
/* TicketUserGroup Fixture generated on: 2009-12-14 01:00:14 : 1260770414*/

class TicketUserGroupFixture extends CakeTestFixture {
	var $name = 'TicketUserGroup';
	var $table = 'ticket_user_groups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ticket_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'ticket_id'  => 1,
		'user_group_id'  => 1,
		'created'  => '2009-12-14 01:00:14',
		'modified'  => '2009-12-14 01:00:14'
	));
}
?>