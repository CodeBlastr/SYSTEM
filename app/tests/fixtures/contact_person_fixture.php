<?php 
/* SVN FILE: $Id$ */
/* ContactPerson Fixture generated on: 2010-01-03 16:23:30 : 1262553810*/

class ContactPersonFixture extends CakeTestFixture {
	var $name = 'ContactPerson';
	var $table = 'contact_people';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contact_person_salutation_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'first_name' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'last_name' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'contact_id' => array('column' => 'contact_id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'contact_person_salutation_id'  => 1,
		'first_name'  => 'Lorem ipsum dolor sit amet',
		'last_name'  => 'Lorem ipsum dolor sit amet',
		'contact_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 16:23:30',
		'modified'  => '2010-01-03 16:23:30'
	));
}
?>