<?php 
/* SVN FILE: $Id$ */
/* FaqMedium Fixture generated on: 2009-12-14 00:44:29 : 1260769469*/

class FaqMediumFixture extends CakeTestFixture {
	var $name = 'FaqMedium';
	var $table = 'faq_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'faq_page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'faq_page_id'  => 1,
		'created'  => '2009-12-14 00:44:29',
		'modified'  => '2009-12-14 00:44:29'
	));
}
?>