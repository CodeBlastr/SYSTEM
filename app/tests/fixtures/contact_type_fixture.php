<?php 
/* SVN FILE: $Id$ */
/* ContactType Fixture generated on: 2010-01-09 21:53:44 : 1263092024*/

class ContactTypeFixture extends CakeTestFixture {
	var $name = 'ContactType';
	var $table = 'contact_types';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2010-01-09 21:53:44',
		'modified'  => '2010-01-09 21:53:44'
	));
}
?>