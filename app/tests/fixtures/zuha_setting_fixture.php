<?php 
/* SVN FILE: $Id$ */
/* ZuhaSetting Fixture generated on: 2009-12-14 10:13:58 : 1260803638*/

class ZuhaSettingFixture extends CakeTestFixture {
	var $name = 'ZuhaSetting';
	var $table = 'zuha_settings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'value' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'value'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-12-14 10:13:58',
		'modified'  => '2009-12-14 10:13:58'
	));
}
?>