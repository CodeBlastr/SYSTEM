<?php
App::uses('Transaction', 'Model');

/**
 * Transaction Test Case
 *
 */
class TransactionTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
	    'plugin.transactions.transaction',
//	    'plugin.transactions.transaction_payment',
//	    'plugin.users.user',
//	    'plugin.transactions.transaction_item',
//	    'plugin.transactions.transaction_shipment',
//	    'plugin.users.customer',
//	    'plugin.contacts.contact',
//	    'plugin.users.assignee',
//	    'plugin.users.creator',
//	    'plugin.users.modifier',
//	    'plugin.transactions.transaction_coupon'
	    );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Transaction = ClassRegistry::init('Transactions.Transaction');
	}

	
	public function testGatherCheckoutOptions() {
	    #debug($this->Transaction);break;
	    $result = $this->Transaction->gatherCheckoutOptions();
	    
	    $this->assertInternalType('array', $result);
	}
	
	
	/**
	 * Tests that User #1 has a cart
	 */
	public function testRetrievingCart() {
	    $userId = 1;
	    $result = $this->Transaction->processCart($userId);
	    $this->assertInternalType('array', $result);
	}
	
	/**
	 * Tests that User #2 has no cart
	 */
	public function testNotRetrievingCart() {
	    $userId = 2;
	    $result = $this->Transaction->processCart($userId);
	    $this->assertEqual($result, FALSE);
	}

	/**
	 * Tests that User 1's subtotal was calculated
	 * @todo make better test
	 */
	public function testSubtotalCalculation() {
	    $userId = 1;
	    $result = $this->Transaction->processCart($userId);
	    $this->assertInternalType('integer', $result['Transaction']['order_charge']);
	}
	
/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Transaction);

		parent::tearDown();
	}

}
