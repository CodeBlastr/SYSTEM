<?php

class ArticleFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string
 */
	public $name = 'Article';

/**
 * fields property
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'), 		
		'title' => array('type' => 'string', 'null' => false),
		'content' => array('type' => 'string', 'null' => false));

/**
 * records property
 *
 * @var array
 */
	public $records = array(
		array(
			  'id' => '4f88970e-b438-4b01-8740-1a14124e0d46', 
			  'title' => 'One Revision Article', 
			  'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'),
		array(
			  'id' => '4f889729-c2fc-4c8a-ba36-1a14124e0d46', 
			  'title' => 'Three Revision Article', 
			  'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'),
		array(
			  'id' => '4f668729-c2fc-4c8a-ba36-1a14124e0d46', 
			  'title' => 'Zero Revision Article', 
			  'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'),
				);
}
