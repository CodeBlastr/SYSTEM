<?php 
/* SVN FILE: $Id$ */
/* ContactPersonSalutation Fixture generated on: 2009-12-16 16:17:48 : 1260998268*/

class ContactPersonSalutationFixture extends CakeTestFixture {
	var $name = 'ContactPersonSalutation';
	var $table = 'contact_person_salutations';
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
		'created'  => '2009-12-16 16:17:48',
		'modified'  => '2009-12-16 16:17:48'
	));
}
?>