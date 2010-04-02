<?php 
/* SVN FILE: $Id$ */
/* FaqPageTag Fixture generated on: 2009-12-14 00:44:41 : 1260769481*/

class FaqPageTagFixture extends CakeTestFixture {
	var $name = 'FaqPageTag';
	var $table = 'faq_page_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'faq_page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'faq_page_id'  => 1,
		'created'  => '2009-12-14 00:44:41',
		'modified'  => '2009-12-14 00:44:41'
	));
}
?>