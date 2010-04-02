<?php 
/* SVN FILE: $Id$ */
/* Wiki Fixture generated on: 2010-02-14 18:17:06 : 1266189426*/

class WikiFixture extends CakeTestFixture {
	var $name = 'Wiki';
	var $table = 'wikis';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'wiki_page_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'public' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'creator_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'wiki_page_id'  => 1,
		'public'  => 1,
		'creator_id'  => 1,
		'modifier_id'  => 1,
		'created'  => '2010-02-14 18:17:06',
		'modified'  => '2010-02-14 18:17:06'
	));
}
?>