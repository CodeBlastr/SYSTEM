<?php 
/* SVN FILE: $Id$ */
/* Ticket Fixture generated on: 2009-12-14 01:00:30 : 1260770430*/

class TicketFixture extends CakeTestFixture {
	var $name = 'Ticket';
	var $table = 'tickets';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'ticket_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'subject' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'description' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'assignedto_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'ticket_type_id'  => 1,
		'subject'  => 'Lorem ipsum dolor sit amet',
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'user_id'  => 1,
		'assignedto_id'  => 1,
		'contact_id'  => 1,
		'created'  => '2009-12-14 01:00:30',
		'modified'  => '2009-12-14 01:00:30'
	));
}
?>