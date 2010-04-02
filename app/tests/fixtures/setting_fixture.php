<?php 
/* SVN FILE: $Id$ */
/* Setting Fixture generated on: 2010-02-14 16:01:47 : 1266181307*/

class SettingFixture extends CakeTestFixture {
	var $name = 'Setting';
	var $table = 'settings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'key' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 48, 'key' => 'unique'),
		'value' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'key' => array('column' => 'key', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'key'  => 'Lorem ipsum dolor sit amet',
		'value'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2010-02-14 16:01:47',
		'modified'  => '2010-02-14 16:01:47'
	));
}
?>