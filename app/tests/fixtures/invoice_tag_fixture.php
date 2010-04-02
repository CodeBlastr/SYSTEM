<?php 
/* SVN FILE: $Id$ */
/* InvoiceTag Fixture generated on: 2009-12-14 00:46:22 : 1260769582*/

class InvoiceTagFixture extends CakeTestFixture {
	var $name = 'InvoiceTag';
	var $table = 'invoice_tags';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'invoice_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'tag_id'  => 1,
		'invoice_id'  => 1,
		'created'  => '2009-12-14 00:46:22',
		'modified'  => '2009-12-14 00:46:22'
	));
}
?>