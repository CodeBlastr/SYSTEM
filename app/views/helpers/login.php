<?php

class LoginHelper extends AppHelper {
    var $value = '';
	var $helpers = array('Session', 'Html');

    function beforeRender() {
		$user_id = $this->Session->read('Auth.User.id');
		
		if (!empty($user_id)) {
			$login = __('Welcome ', true);
			$login .= $this->Html->link(__($this->Session->read('Auth.User.username'), true), array(
				'plugin' => 'profiles',
				'controller' => 'profiles',
				'action' => 'view',
				'user_id' => $this->Session->read('Auth.User.id'),
				));
			$login .= __(' - ', true);
			$login .= $this->Html->link(__('Logout', true), array(
				'plugin' => null,
				'controller' => 'users',
				'action' => 'logout',
				));
		} else {
			$login = $this->Html->link(__('Sign up', true), array(
				'plugin' => null,
				'controller' => 'users',
				'action' => 'add'
				));
			$login .= __(' - ', true);
			$login .= $this->Html->link(__('Sign in', true), array(
				'plugin' => null,
				'controller' => 'users',
				'action' => 'login'
				));
		}
		
    	$view = ClassRegistry::getObject('view');
	    $view->set('login_for_layout', $login);
    }

    function setValue($value) {
        $this->value = $value;
    }
}
?>