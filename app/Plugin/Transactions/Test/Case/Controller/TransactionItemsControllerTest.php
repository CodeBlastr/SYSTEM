<?php
App::uses('TransactionItemsController', 'Transactions.Controller');

/**
 * TestTransactionItemsController *
 */
class TestTransactionItemsController extends TransactionItemsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * TransactionItemsController Test Case
 *
 */
class TransactionItemsControllerTestCase extends ControllerTestCase  {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('transactions.transaction_item', 'catalogs.catalog_item', 'transactions.transaction_payment', 'transactions.transaction', 'transactions.transaction_shipment', 'users.user', 'transactions.transaction_coupon', 'users.customer', 'contacts.contact', 'users.assignee', 'app.cim_profile', 'app.cim_payment_profile', 'users.creator', 'users.modifier', 'conditions.condition');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TransactionItems = new TestTransactionItemsController();
		$this->TransactionItems->constructClasses();
//		App::uses('Users', 'users');
//                   $this->Users = $this->generate('Users', array(
//                       'components' => array(
//                           'Session',
//                           'Acl'
//                       )
//                   ));
//                   $this->User = ClassRegistry::init('User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TransactionItems);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
//	    $this->TransactionItems->User = 
//	    $this->TransactionItems->Auth->login( $this->TransactionItems->User->read(null, 1) );
	     
//		$this->controller = $this->generate('Users', array(
//		    'components' => array('Auth' => array('user')) //We mock the Auth Component here
//		));
//		$this->controller->Auth->expects($this->once())->method('user') //The method user()
//		    ->with('id') //Will be called with first param 'id'
//		    ->will($this->returnValue(1)); //And will return something for me
		
		//CakeSession::write('Auth.User.id', 1);
		
		$result = $this->testAction('/transactions/transaction_items');
		debug($result);
	}
/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}
/**
 * testAdd method
 *
 * @return void
 */
	public function testBadAdd() {
	    $data = array(
		'price' => 'asdf'
	    );
	    $result = $this->testAction('/transactions/transaction_items/add', array('data' => $data, 'method' => 'post'));
	    debug($result);
	}
	
	public function testGoodAdd() {
	    $data = array(
		'name' => 'Test Product',
		'quantity' => 1,
		'price' => 100.25
	    );
	    $result = $this->testAction('/transactions/transaction_items/add', array('data' => $data, 'method' => 'post'));
	    debug($result);
	}
/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}
/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}
}
