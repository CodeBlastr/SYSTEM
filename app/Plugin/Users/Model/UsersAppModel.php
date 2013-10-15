<?php
App::uses('AppModel', 'Model');

class UsersAppModel extends AppModel {
	
/**
 * Menu Init method
 * Used by WebpageMenuItem to initialize when someone creates a new menu item for the users plugin.
 * 
 */
 	public function menuInit($data = null) {
 		// link to users index, login, register, and my
		$data['WebpageMenuItem']['item_url'] = '/users/users/index';
		$data['WebpageMenuItem']['item_text'] = 'Users Index';
		$data['WebpageMenuItem']['name'] = 'Users Index';
		$data['ChildMenuItem'] = array(
			array(
				'name' => 'Login',
				'item_text' => 'Login',
				'item_url' => '/users/users/login'
			),
			array(
				'name' => 'Register',
				'item_text' => 'Register',
				'item_url' => '/users/users/register'
			),
			array(
				'name' => 'User Profile',
				'item_text' => 'User Profile',
				'item_url' => '/users/users/my'
			)
		);
 		return $data;
 	}

}
