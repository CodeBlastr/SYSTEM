<?php

class LoginHelper extends AppHelper {
    var $value = '';
	var $helpers = array('Session', 'Html', 'Facebook.Facebook');
	#var $components = array('Facebook.Connect');

    function beforeRender() {
		$user_id = $this->Session->read('Auth.User.id');
		
		$login = '<div id="login-helper" class="login">';
		
		if (!empty($user_id)) {
			$login .= '<p>'.__('Welcome ', true);
			$login .= $this->Html->link(__($this->Session->read('Auth.User.username'), true), array(
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'view',
				$this->Session->read('Auth.User.id'),
			), array(
				'class' => 'login-link',
				'id' => 'userid-link'
				)
			);
			$login .= __(' - ', true);
			$facebookId = $this->Session->read('Auth.User.facebook_id');
			if(!empty($facebookId)) {
				# use the facebook logout if it exists
				$login .= $this->Facebook->logout(array('label' => ' Logout', 'redirect' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'))); 
			} else {																	   
				$login .= $this->Html->link(__('Logout', true), array(
					'plugin' => 'users',
					'controller' => 'users',
					'action' => 'logout',
				), array(
					'class' => 'login-link',
					'id' => 'logout-link'
					)
				);
			}
		} else {
			$login .= $this->Html->link(__('Sign up', true), array(
				'plugin' => 'users',
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
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'login',
			), array(
				'class' => 'login-link',
				'id' => 'signin-link'
				)
			);
			$login .= $this->Facebook->login(array('perms' => 'email,publish_stream'));
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