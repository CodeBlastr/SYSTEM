<?php 
/* SVN FILE: $Id$ */
/* QuoteMedium Fixture generated on: 2009-12-14 00:58:22 : 1260770302*/

class QuoteMediumFixture extends CakeTestFixture {
	var $name = 'QuoteMedium';
	var $table = 'quote_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quote_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'quote_id'  => 1,
		'created'  => '2009-12-14 00:58:22',
		'modified'  => '2009-12-14 00:58:22'
	));
}
?>