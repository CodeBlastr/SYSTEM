<?php

############### PERMISSIONS TUTORIAL ########################
# http://book.cakephp.org/view/647/An-Automated-tool-for-creating-ACOs
#############################################################


class UserGroup extends AppModel {

	var $name = 'UserGroup';	
	var $actsAs = array('Acl' => array('requester'));
 	var $userField = array();
	function parentNode() {
	    return null;
	}


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_group_id',
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
?>