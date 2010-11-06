<?php
class UserGroup extends AppModel {

	var $name = 'UserGroup';	
	var $actsAs = array('Acl' => array('requester'));
 	var $userField = array();
 	
 	// Used to define if this model requires record level user access control? 
	var $userLevel = false;
	
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
	
	/*
	@todo This model needs to be updated so that when you delete a user group
	it will also update the aros table by removing the UserGroup
	*/

}
?>