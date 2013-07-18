<?php
App::uses('UserRole', 'Users.Model');

/**
 * UserRole Test Case
 *
 */
class UserRoleTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.transaction_address',
		'app.transaction',
		'app.user',
		'app.transaction_item',
		'app.customer', 
		'app.contact',
		'app.assignee',
		'app.creator',
		'app.modifier'
		);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserRole = ClassRegistry::init('Users.UserRole');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserRole);

		parent::tearDown();
	}
    
/**
 * testAdd method
 *
 * @return void
 */
    public function testAdd() {
        
        
    }
	
	/**
	 * If your app is configured, THIS WILL SUBMIT A REQUEST TO YOUR PAYMENT PROCESSOR
	 */
	public function testAfterSuccessfulPayment() {
		$submittedTransaction = array(
			'TransactionAddress' => array(
				array(
					'email' => 'joel@razorit.com',
					'first_name' => 'Joel',
					'last_name' => 'Byrnes',
					'street_address_1' => '123 Test Drive',
					'street_address_2' => '',
					'city' => 'North Syracuse',
					'state' => 'NY',
					'zip' => '13212',
					'country' => 'US',
					'shipping' => '0',
					'phone' => '1234567890',
					'type' => 'billing'
				),
				array(
					'street_address_1' => '',
					'street_address_2' => '',
					'city' => '',
					'state' => '',
					'zip' => '',
					'country' => 'US',
					'type' => 'shipping'
				)
			),
			'Transaction' => array(
				'mode' => 'PAYSIMPLE.CC',
				'card_number' => '4111111111111111',
				'card_exp_month' => '1',
				'card_exp_year' => '2014',
				'card_sec' => '123',
				'ach_routing_number' => '',
				'ach_account_number' => '',
				'ach_bank_name' => '',
				'ach_is_checking_account' => '',
				'quantity' => '',
                'status'=>'open',
                'sub_total' => '2,257.50',
                'customer_id' => '1',  
             
			),
			'TransactionItem' => array(
				array(
					'id' => '50773d75-cab4-40dd-b34c-187800000001',
					'quantity' => '2' // different qty than what was originally in the cart
				)
			),
			'TransactionCoupon' => array(
				'code' => ''
			)
		);
		$this->UserRole->afterSuccessfulPayment($submittedTransaction);
	}

}
