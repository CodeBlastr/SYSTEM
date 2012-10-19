<?php
App::uses('TransactionsAppModel', 'Transactions.Model');
/**
 * TransactionPayment Model
 *
 * @property Transaction $Transaction
 * @property Transaction $Transaction
 * @property User $User
 * @property CimProfile $CimProfile
 * @property CimPaymentProfile $CimPaymentProfile
 * @property TransactionItem $TransactionItem
 */
class TransactionPayment extends TransactionsAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'value' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Transaction' => array(
			'className' => 'Transactions.Transaction',
			'foreignKey' => 'transaction_payment_id',
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
		'Transaction' => array(
			'className' => 'Transactions.Transaction',
			'foreignKey' => 'transaction_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
//		'CimProfile' => array(
//			'className' => 'CimProfile',
//			'foreignKey' => 'cim_profile_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'CimPaymentProfile' => array(
//			'className' => 'CimPaymentProfile',
//			'foreignKey' => 'cim_payment_profile_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'TransactionItem' => array(
			'className' => 'Transactions.TransactionItem',
			'foreignKey' => 'transaction_payment_id',
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

}
