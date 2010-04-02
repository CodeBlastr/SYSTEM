<?php
class WikiPage extends AppModel {

	var $name = 'WikiPage';
	var $validate = array(
		'title' => array('notempty'),
		'wiki_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Wiki' => array(
			'className' => 'Wiki',
			'foreignKey' => 'wiki_id',
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
		'WikiContent' => array(
			'className' => 'WikiContent',
			'foreignKey' => 'wiki_page_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Wiki' => array(
			'className' => 'Wiki',
			'foreignKey' => 'wiki_page_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'WikiContentVersion' => array(
			'className' => 'WikiContentVersion',
			'foreignKey' => 'wiki_page_id',
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
		'Media' => array(
			'className' => 'Media',
			'joinTable' => 'wiki_pages_media',
			'foreignKey' => 'wiki_page_id',
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
			'joinTable' => 'wiki_pages_tags',
			'foreignKey' => 'wiki_page_id',
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