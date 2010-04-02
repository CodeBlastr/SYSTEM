<?php
class WikiContentVersion extends AppModel {

	var $name = 'WikiContentVersion';
	var $validate = array(
		'version' => array('numeric'),
		'wiki_page_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'WikiPage' => array(
			'className' => 'WikiPage',
			'foreignKey' => 'wiki_page_id',
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

}
?>