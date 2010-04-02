<?php 
/* SVN FILE: $Id$ */
/* ContactAddress Fixture generated on: 2010-01-03 16:18:07 : 1262553487*/

class ContactAddressFixture extends CakeTestFixture {
	var $name = 'ContactAddress';
	var $table = 'contact_addresses';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contact_address_type_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'street1' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'street2' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'city' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'state_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'zip_postal' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'country_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'primary' => array('type'=>'boolean', 'null' => true, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'contact_address_type_id'  => 1,
		'street1'  => 'Lorem ipsum dolor sit amet',
		'street2'  => 'Lorem ipsum dolor sit amet',
		'city'  => 'Lorem ipsum dolor sit amet',
		'state_id'  => 1,
		'zip_postal'  => 'Lorem ipsum dolor sit amet',
		'country_id'  => 1,
		'primary'  => 1,
		'contact_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 16:18:07',
		'modified'  => '2010-01-03 16:18:07'
	));
}
?>