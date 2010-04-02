<?php
class WikiPagesTag extends AppModel {

	var $name = 'WikiPagesTag';
	var $validate = array(
		'tag_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
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