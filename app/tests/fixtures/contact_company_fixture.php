<?php 
/* SVN FILE: $Id$ */
/* ContactCompany Fixture generated on: 2010-01-03 21:45:05 : 1262573105*/

class ContactCompanyFixture extends CakeTestFixture {
	var $name = 'ContactCompany';
	var $table = 'contact_companies';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'contact_id' => array('column' => 'contact_id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'contact_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 21:45:05',
		'modified'  => '2010-01-03 21:45:05'
	));
}
?>