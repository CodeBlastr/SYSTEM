<?php

class LoginHelper extends AppHelper {
    var $value = '';
	var $helpers = array('Session', 'Html');

    function beforeRender() {
		$user_id = $this->Session->read('Auth.User.id');
		
		$login = '<div id="login-helper" class="login">';
		
		if (!empty($user_id)) {
			$login .= '<p>'.__('Welcome ', true);
			$login .= $this->Html->link(__($this->Session->read('Auth.User.username'), true), array(
				'plugin' => 'profiles',
				'controller' => 'profiles',
				'action' => 'view',
				'user_id' => $this->Session->read('Auth.User.id'),
			), array(
				'class' => 'login-link',
				'id' => 'userid-link'
				)
			);
			$login .= __(' - ', true);
			$login .= $this->Html->link(__('Logout', true), array(
				'plugin' => null,
				'controller' => 'users',
				'action' => 'logout',
			), array(
				'class' => 'login-link',
				'id' => 'logout-link'
				)
			);
		} else {
			$login = $this->Html->link(__('Sign up', true), array(
				'plugin' => null,
				'controller' => 'users',
				'action' => 'add',
				'id' => 'login-signup',
				'class' => 'login-link',
			), array(
				'class' => 'login-link',
				'id' => 'signup-link'
				)
			);
			$login .= __(' - ', true);
			$login .= $this->Html->link(__('Sign in', true), array(
				'plugin' => null,
				'controller' => 'users',
				'action' => 'login',
			), array(
				'class' => 'login-link',
				'id' => 'signin-link'
				)
			);
		}
		$login .= '</p></div>';
		
    	$view = ClassRegistry::getObject('view');
	    $view->set('login_for_layout', $login);
    }

    function setValue($value) {
        $this->value = $value;
    }
}
?>