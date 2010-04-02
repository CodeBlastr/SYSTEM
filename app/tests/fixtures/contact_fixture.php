<?php 
/* SVN FILE: $Id$ */
/* Contact Fixture generated on: 2010-01-03 16:04:38 : 1262552678*/

class ContactFixture extends CakeTestFixture {
	var $name = 'Contact';
	var $table = 'contacts';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'contact_type_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact_source_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact_industry_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact_rating_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'owner_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'assignee_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'contact_type_id'  => 1,
		'contact_source_id'  => 1,
		'contact_industry_id'  => 1,
		'contact_rating_id'  => 1,
		'owner_id'  => 1,
		'assignee_id'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-01-03 16:04:38',
		'modified'  => '2010-01-03 16:04:38'
	));
}
?>