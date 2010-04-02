<?php 
/* SVN FILE: $Id$ */
/* TicketTag Fixture generated on: 2009-12-14 00:59:56 : 1260770396*/

class TicketTagFixture extends CakeTestFixture {
	var $name = 'TicketTag';
	var $table = 'ticket_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'ticket_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'ticket_id'  => 1,
		'created'  => '2009-12-14 00:59:56',
		'modified'  => '2009-12-14 00:59:56'
	));
}
?>