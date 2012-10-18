<?php
/**
 * TransactionFixture
 *
 */
class TransactionFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Transactions.Transaction');
	
	
/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '5077241d-9040-43c9-85b1-22d400000000',
			'transaction_payment_id' => 'Lorem ipsum dolor sit amet',
			'transaction_shipment_id' => 'Lorem ipsum dolor sit amet',
			'transaction_coupon_id' => 'Lorem ipsum dolor sit amet',
			'processor_response' => 'Lorem ipsum dolor sit amet',
			'introduction' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'conclusion' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'status' => 'Lorem ipsum dolor sit amet',
			'mode' => 'Lorem ipsum dolor sit a',
			'total' => 1,
			'is_virtual' => 1,
			'is_arb' => 1,
			'customer_id' => '1',
			'contact_id' => '1',
			'assignee_id' => '1',
			'creator_id' => '1',
			'modifier_id' => '1',
			'created' => '2012-10-11 19:55:09',
			'modified' => '2012-10-11 19:55:09'
		),
	);
}
