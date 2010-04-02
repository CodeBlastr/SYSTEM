<?php 
/* SVN FILE: $Id$ */
/* TicketMedium Fixture generated on: 2009-12-14 00:59:47 : 1260770387*/

class TicketMediumFixture extends CakeTestFixture {
	var $name = 'TicketMedium';
	var $table = 'ticket_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'ticket_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'ticket_id'  => 1,
		'created'  => '2009-12-14 00:59:47',
		'modified'  => '2009-12-14 00:59:47'
	));
}
?>