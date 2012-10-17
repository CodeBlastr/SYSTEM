<?php
App::uses('TransactionsAppModel', 'Transactions.Model');
/**
 * Transaction Model
 *
 * @property TransactionShipment $TransactionShipment
 * @property TransactionPayment $TransactionPayment
 * @property TransactionShipment $TransactionShipment
 * @property TransactionCoupon $TransactionCoupon
 * @property Customer $Customer
 * @property Contact $Contact
 * @property Assignee $Assignee
 * @property TransactionItem $TransactionItem
 * @property TransactionPayment $TransactionPayment
 */
class Transaction extends TransactionsAppModel {
 public $name = 'Transaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'TransactionShipment' => array(
			'className' => 'Transactions.TransactionShipment',
			'foreignKey' => 'transaction_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

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
//		'TransactionShipment' => array(
//			'className' => 'Transactions.TransactionShipment',
//			'foreignKey' => 'transaction_shipment_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
		'TransactionCoupon' => array(
			'className' => 'Transactions.TransactionCoupon',
			'foreignKey' => 'transaction_coupon_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Customer' => array(
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
			'className' => 'Users.User',
			'foreignKey' => 'assignee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'TransactionItem' => array(
			'className' => 'Transactions.TransactionItem',
			'foreignKey' => 'transaction_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TransactionPayment' => array(
			'className' => 'Transactions.TransactionPayment',
			'foreignKey' => 'transaction_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	
	public function gatherCheckoutOptions() {
	    $options['ssl'] = defined('__ORDERS_SSL') ? unserialize(__ORDERS_SSL) : null;
	    $options['trustLogos'] = !empty($ssl['trustLogos']) ? $ssl['trustLogos'] : null;
	    $options['enableShipping'] = defined('__ORDERS_ENABLE_SHIPPING') ? __ORDERS_ENABLE_SHIPPING : false;
	    $options['fedexSettings'] = defined('__ORDERS_FEDEX') ? unserialize(__ORDERS_FEDEX) : null;
	    $options['paymentMode'] = defined('__ORDERS_DEFAULT_PAYMENT') ? __ORDERS_DEFAULT_PAYMENT : null;
	    $options['paymentOptions'] = defined('__ORDERS_ENABLE_PAYMENT_OPTIONS') ? unserialize(__ORDERS_ENABLE_PAYMENT_OPTIONS) : null;

	    if (defined('__ORDERS_ENABLE_SINGLE_PAYMENT_TYPE')) :
		$options['singlePaymentKeys'] = $this->Session->read('OrderPaymentType');
		if (!empty($options['singlePaymentKeys'])) :
		    $options['singlePaymentKeys'] = array_flip($options['singlePaymentKeys']);
		    $options['paymentOptions'] = array_intersect_key($options['paymentOptions'], $options['singlePaymentKeys']);
		endif;
	    endif;

	    $options['defaultShippingCharge'] = defined('__ORDERS_FLAT_SHIPPING_RATE') ? __ORDERS_FLAT_SHIPPING_RATE : 0;
	    
	    return $options;
	}
	
	
}
