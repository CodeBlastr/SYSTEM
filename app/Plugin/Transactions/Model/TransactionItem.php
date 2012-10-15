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
}
