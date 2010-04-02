<?php 
/* SVN FILE: $Id$ */
/* Quote Fixture generated on: 2009-12-14 00:58:59 : 1260770339*/

class QuoteFixture extends CakeTestFixture {
	var $name = 'Quote';
	var $table = 'quotes';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'introduction' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'conclusion' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'sendto' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'start_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'end_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'published' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'introduction'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'conclusion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'sendto'  => 'Lorem ipsum dolor sit amet',
		'start_date'  => '2009-12-14 00:58:59',
		'end_date'  => '2009-12-14 00:58:59',
		'published'  => 1,
		'user_id'  => 1,
		'contact_id'  => 1,
		'created'  => '2009-12-14 00:58:59',
		'modified'  => '2009-12-14 00:58:59'
	));
}
?>