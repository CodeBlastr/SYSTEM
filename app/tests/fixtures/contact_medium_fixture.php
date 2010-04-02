<?php 
/* SVN FILE: $Id$ */
/* ContactMedium Fixture generated on: 2009-12-14 00:38:18 : 1260769098*/

class ContactMediumFixture extends CakeTestFixture {
	var $name = 'ContactMedium';
	var $table = 'contact_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'contact_id'  => 1,
		'created'  => '2009-12-14 00:38:18',
		'modified'  => '2009-12-14 00:38:18'
	));
}
?>