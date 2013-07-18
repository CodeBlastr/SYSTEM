<?php
/**
 * ContactFixture
 *
 */
class ContactFixture extends CakeTestFixture {
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Contacts.Contact');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '51799607-6440-4cc9-8a72-797145a3a949',
			'name' => 'Josie\'s Company',
			'is_company' => 1
		),
		array(
			'id' => '4ea754d1-2f50-4f19-8998-4d1245a3a949',
			'name' => 'Josie Wales',
			'is_company' => 0
		),
	);
}
