<?php 
/* SVN FILE: $Id$ */
/* FaqPage Fixture generated on: 2009-12-14 00:45:00 : 1260769500*/

class FaqPageFixture extends CakeTestFixture {
	var $name = 'FaqPage';
	var $table = 'faq_pages';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'introduction' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'conclusion' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'public' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'faq_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'title'  => 'Lorem ipsum dolor sit amet',
		'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'conclusion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'public'  => 1,
		'user_id'  => 1,
		'faq_id'  => 1,
		'created'  => '2009-12-14 00:45:00',
		'modified'  => '2009-12-14 00:45:00'
	));
}
?>