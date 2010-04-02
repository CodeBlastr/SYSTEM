<?php 
/* SVN FILE: $Id$ */
/* QuoteItem Fixture generated on: 2009-12-14 00:58:14 : 1260770294*/

class QuoteItemFixture extends CakeTestFixture {
	var $name = 'QuoteItem';
	var $table = 'quote_items';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'price' => array('type'=>'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'description' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'price'  => 'Lorem ipsum dolor sit amet',
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'user_id'  => 1,
		'created'  => '2009-12-14 00:58:14',
		'modified'  => '2009-12-14 00:58:14'
	));
}
?>