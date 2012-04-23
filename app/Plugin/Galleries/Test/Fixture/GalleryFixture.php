<?php
/**
 * GalleryFixture
 *
 */
class GalleryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'gallery_thumb_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'The gallery image which serves as the front lead in to the gallery.'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'thumb_width' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'thumb_height' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'medium_width' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'medium_height' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'full_width' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'full_height' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'conversion_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'transition_speed' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5),
		'creator_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'modifier_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'gallery_thumb_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'type' => 'Lorem ipsum dolor sit amet',
			'thumb_width' => 1,
			'thumb_height' => 1,
			'medium_width' => 1,
			'medium_height' => 1,
			'full_width' => 1,
			'full_height' => 1,
			'conversion_type' => 'Lorem ipsum dolor sit amet',
			'transition_speed' => 1,
			'creator_id' => 1,
			'modifier_id' => 1,
			'created' => '2012-04-20 02:24:13',
			'modified' => '2012-04-20 02:24:13'
		),
	);
}
