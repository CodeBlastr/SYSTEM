<?php

App::uses('TransactionsAppModel', 'Transactions.Model');

/**
 * TransactionItem Model
 *
 * @property CatalogItem $CatalogItem
 * @property TransactionPayment $TransactionPayment
 * @property TransactionShipment $TransactionShipment
 * @property Transaction $Transaction
 * @property Customer $Customer
 * @property Contact $Contact
 * @property Assignee $Assignee
 * @property Creator $Creator
 * @property Modifier $Modifier
 */
class TransactionItem extends TransactionsAppModel {

    public $name = 'TransactionItem';

    public $validate = array(
	'price' => 'notEmpty'
    );
    
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed


    public $hasOne = 'Transaction';

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
	'TransactionPayment' => array(
	    'className' => 'Transactions.TransactionPayment',
	    'foreignKey' => 'transaction_payment_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	),
	'TransactionShipment' => array(
	    'className' => 'Transactions.TransactionShipment',
	    'foreignKey' => 'transaction_shipment_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	),
	'Transaction' => array(
	    'className' => 'Transactions.Transaction',
	    'foreignKey' => 'transaction_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	),
	'Customer' => array(
	    //'className' => 'Users.Customer',
	    'className' => 'Users.User',
	    'foreignKey' => 'customer_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	),
	'Contact' => array(
	    'className' => 'Contacts.Contact',
	    'foreignKey' => 'contact_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	),
	'Assignee' => array(
	    //'className' => 'Users.Assignee',
	    'className' => 'Users.User',
	    'foreignKey' => 'assignee_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	),
    );


    /**
     * Creates a new cart or returns the id of the existing cart for a user, based on their session's User.id
     * @return string Id of the cart in question
     */
    public function setCartId() {
	// an item was added, check for a shopping cart.
	$myCart = $this->Transaction->find('first', array(
	    'customer_id' => CakeSession::read('Auth.User.id')
		));
	if (!$myCart) {
	    // no cart found. give them a new shopping cart.
	    $this->Transaction->create(array(
		'customer_id' => CakeSession::read('Auth.User.id')
	    ));
	    $this->Transaction->save();
	} else {
	    // existing shopping cart found.  use it.
	    $this->Transaction->id = $myCart['Transaction']['id'];
	}

	return $this->Transaction->id;
    }
    
    
    /**
     * This function ensures that a TransactionItem has it's fields filled out correctly
     * by calling upon the Model that the Item belongs to.
     * @param array $data
     * @return array
     */
    public function mapItemData($data) {

	if(empty($data['TransactionItem']['model'])) {
	    throw new InternalErrorException(__('Invalid transaction item'));
	}
	
	App::uses($data['TransactionItem']['model'], ZuhaInflector::pluginize($data['TransactionItem']['model']) . '.Model');
	$Model = new $data['TransactionItem']['model'];

	$itemData = $Model->mapTransactionItem($data['TransactionItem']['foreign_key']);

	$itemData = Set::merge(
		$itemData,
		$data,
		array(
		    'TransactionItem' => array(
			'transaction_id' => $this->Transaction->id,
			'customer_id' => CakeSession::read('Auth.User.id')
		    )
		)
	);
	
	return $itemData;
	
	
    }
    
    
    /**
     * @todo check stock and cart max
     * @param array $data
     */
    public function verifyItemRequest($data) {
//	App::uses($data['TransactionItem']['model'], ZuhaInflector::pluginize($data['TransactionItem']['model']) . '.Model');
//	$Model = new $data['TransactionItem']['model'];

	return true;
    }

    
    public function statuses() {
        $statuses = array();
        foreach (Zuha::enum('ORDER_ITEM_STATUS') as $status) {
            $statuses[Inflector::underscore($status)] = $status;
        }
        return Set::merge(array('incart' => 'In Cart', 'paid' => 'Paid', 'shipped' => 'Shipped'), $statuses);
    }
    
    
}
