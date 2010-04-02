<?php
class WikiPagesMedium extends AppModel {

	var $name = 'WikiPagesMedium';
	var $validate = array(
		'medium_id' => array('numeric'),
		'wiki_page_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Medium' => array(
			'className' => 'Medium',
			'foreignKey' => 'medium_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'WikiPage' => array(
			'className' => 'WikiPage',
			'foreignKey' => 'wiki_page_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>