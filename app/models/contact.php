<?php
class Contact extends AppModel {

	var $name = 'Contact';
	var $validate = array(
		'creator_id' => array('numeric'),
		'modifier_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ContactType' => array(
			'className' => 'ContactType',
			'foreignKey' => 'contact_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContactSource' => array(
			'className' => 'ContactSource',
			'foreignKey' => 'contact_source_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContactIndustry' => array(
			'className' => 'ContactIndustry',
			'foreignKey' => 'contact_industry_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContactRating' => array(
			'className' => 'ContactRating',
			'foreignKey' => 'contact_rating_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Owner' => array(
			'className' => 'User',
			'foreignKey' => 'owner_id',
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

	var $hasOne = array(
		'ContactCompany' => array(
			'className' => 'ContactCompany',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContactPerson' => array(
			'className' => 'ContactPerson',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ContactActivity' => array(
			'className' => 'ContactActivity',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContactAddress' => array(
			'className' => 'ContactAddress',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContactDetail' => array(
			'className' => 'ContactDetail',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContactTask' => array(
			'className' => 'ContactTask',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Invoice' => array(
			'className' => 'Invoice',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ProjectIssue' => array(
			'className' => 'ProjectIssue',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Quote' => array(
			'className' => 'Quote',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'contact_id',
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

	var $hasAndBelongsToMany = array(
		'Campaign' => array(
			'className' => 'Campaign',
			'joinTable' => 'campaigns_contacts',
			'foreignKey' => 'contact_id',
			'associationForeignKey' => 'campaign_id',
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
		'RelatedContact' => array(
			'className' => 'ContactsRelationship',
			'joinTable' => 'contacts_relationships',
			'foreignKey' => 'contact_id',
			'associationForeignKey' => 'id',
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
			'joinTable' => 'contacts_media',
			'foreignKey' => 'contact_id',
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
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'contacts_tags',
			'foreignKey' => 'contact_id',
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
		),
		'Watcher' => array(
			'className' => 'ProjectsWatcher',
			'joinTable' => 'projects_watchers',
			'foreignKey' => 'contact_id',
			'associationForeignKey' => 'id',
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