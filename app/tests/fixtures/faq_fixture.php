<?php 
/* SVN FILE: $Id$ */
/* Faq Fixture generated on: 2009-12-14 00:45:33 : 1260769533*/

class FaqFixture extends CakeTestFixture {
	var $name = 'Faq';
	var $table = 'faqs';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'public' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'public'  => 1,
		'user_id'  => 1,
		'created'  => '2009-12-14 00:45:33',
		'modified'  => '2009-12-14 00:45:33'
	));
}
?>