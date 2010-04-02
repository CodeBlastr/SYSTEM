<?php 
/* SVN FILE: $Id$ */
/* WikiPagesMedium Fixture generated on: 2010-02-14 18:15:00 : 1266189300*/

class WikiPagesMediumFixture extends CakeTestFixture {
	var $name = 'WikiPagesMedium';
	var $table = 'wiki_pages_media';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'medium_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'wiki_page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'medium_id'  => 1,
		'wiki_page_id'  => 1,
		'created'  => '2010-02-14 18:15:00',
		'modified'  => '2010-02-14 18:15:00'
	));
}
?>