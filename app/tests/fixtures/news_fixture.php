<?php
/* News Fixture generated on: 2011-04-06 07:04:40 : 1302074200 */
class NewsFixture extends CakeTestFixture {
	var $name = 'News';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'url' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'creator_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modifier_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'url' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'name' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1,
			'creator_id' => 1,
			'modifier_id' => 1,
			'created' => '2011-04-06 07:16:40',
			'modified' => '2011-04-06 07:16:40'
		),
	);
}
?>