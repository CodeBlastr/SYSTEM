<?php 
/* SVN FILE: $Id$ */
/* ContactRating Fixture generated on: 2010-01-09 21:55:53 : 1263092153*/

class ContactRatingFixture extends CakeTestFixture {
	var $name = 'ContactRating';
	var $table = 'contact_ratings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2010-01-09 21:55:53',
		'modified'  => '2010-01-09 21:55:53'
	));
}
?>