<?php
class Order extends AppModel {

	var $name = 'Order';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'OrderPaymentType' => array(
			'className' => 'OrderPaymentType',
			'foreignKey' => 'order_payment_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'OrderShippingType' => array(
			'className' => 'OrderShippingType',
			'foreignKey' => 'order_shipping_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'OrderStatusType' => array(
			'className' => 'OrderStatusType',
			'foreignKey' => 'order_status_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Assignee' => array(
			'className' => 'User',
			'foreignKey' => 'assignee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Media' => array(
			'className' => 'Media',
			'joinTable' => 'orders_media',
			'foreignKey' => 'order_id',
			'associationForeignKey' => 'media_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'CatalogItem' => array(
			'className' => 'CatalogItem',
			'joinTable' => 'orders_catalog_items',
			'foreignKey' => 'order_id',
			'associationForeignKey' => 'catalog_item_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'orders_tags',
			'foreignKey' => 'order_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>