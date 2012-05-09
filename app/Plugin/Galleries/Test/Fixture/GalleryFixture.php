<?php
/**
 * GalleryFixture
 *
 */
class GalleryFixture extends CakeTestFixture {
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Galleries.Gallery');

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
