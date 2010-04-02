<?php 
/* SVN FILE: $Id$ */
/* ContactsTag Fixture generated on: 2010-01-05 21:22:20 : 1262744540*/

class ContactsTagFixture extends CakeTestFixture {
	var $name = 'ContactsTag';
	var $table = 'contacts_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'contact_id' => array('column' => 'contact_id', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'contact_id'  => 1,
		'created'  => '2010-01-05 21:22:20',
		'modified'  => '2010-01-05 21:22:20'
	));
}
?>