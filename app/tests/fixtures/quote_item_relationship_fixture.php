<?php 
/* SVN FILE: $Id$ */
/* QuoteItemRelationship Fixture generated on: 2009-12-14 00:58:04 : 1260770284*/

class QuoteItemRelationshipFixture extends CakeTestFixture {
	var $name = 'QuoteItemRelationship';
	var $table = 'quote_item_relationships';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quote_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quote_item_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'quote_id'  => 1,
		'quote_item_id'  => 1,
		'created'  => '2009-12-14 00:58:04',
		'modified'  => '2009-12-14 00:58:04'
	));
}
?>