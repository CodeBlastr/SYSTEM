<?php
App::uses('UsersAppModel', 'Users.Model');

class UserFollower extends UsersAppModel {
	public $name = 'UserFollower';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
    
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserRef' => array(
            'className' => 'Users.User',
            'foreignKey' => 'follower_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

}
