<?php
class ProjectsWiki extends AppModel {

	var $name = 'ProjectsWiki';
	var $validate = array(
		'project_id' => array('numeric'),
		'wiki_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Wiki' => array(
			'className' => 'Wiki',
			'foreignKey' => 'wiki_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>