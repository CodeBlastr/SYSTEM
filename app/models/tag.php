<?php
class Tag extends AppModel {

	var $name = 'Tag';
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'TagParent' => array(
			'className' => 'Tag',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'BlogPost' => array(
			'className' => 'BlogPost',
			'joinTable' => 'blog_posts_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'blog_post_id',
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
		'CatalogBrand' => array(
			'className' => 'CatalogBrand',
			'joinTable' => 'catalog_brands_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'catalog_brand_id',
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
			'joinTable' => 'catalog_items_tags',
			'foreignKey' => 'tag_id',
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
		'Catalog' => array(
			'className' => 'Catalog',
			'joinTable' => 'catalogs_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'catalog_id',
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
		'Contact' => array(
			'className' => 'Contact',
			'joinTable' => 'contacts_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'contact_id',
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
		'Faq' => array(
			'className' => 'Faq',
			'joinTable' => 'faqs_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'faq_id',
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
		'Invoice' => array(
			'className' => 'Invoice',
			'joinTable' => 'invoices_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'invoice_id',
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
		'Media' => array(
			'className' => 'Media',
			'joinTable' => 'tags_media',
			'foreignKey' => 'tag_id',
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
		'Order' => array(
			'className' => 'Order',
			'joinTable' => 'orders_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'order_id',
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
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'projects_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'project_id',
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
		'Quote' => array(
			'className' => 'Quote',
			'joinTable' => 'quotes_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'quote_id',
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
		'Ticket' => array(
			'className' => 'Ticket',
			'joinTable' => 'tickets_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'ticket_id',
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
		'Webpage' => array(
			'className' => 'Webpage',
			'joinTable' => 'webpages_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'webpage_id',
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
		'WikiPage' => array(
			'className' => 'WikiPage',
			'joinTable' => 'wiki_pages_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'wiki_page_id',
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