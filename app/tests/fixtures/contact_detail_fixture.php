<?php 
/* SVN FILE: $Id$ */
/* ContactDetail Fixture generated on: 2010-01-03 16:21:48 : 1262553708*/

class ContactDetailFixture extends CakeTestFixture {
	var $name = 'ContactDetail';
	var $table = 'contact_details';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contact_detail_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'value' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'default' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'contact_detail_type_id'  => 1,
		'value'  => 'Lorem ipsum dolor sit amet',
		'default'  => 1,
		'contact_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 16:21:48',
		'modified'  => '2010-01-03 16:21:48'
	));
}
?>