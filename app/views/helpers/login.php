<?php

class LoginHelper extends AppHelper {
<<<<<<< HEAD
    var $beforeValue = '';
    var $afterValue = '';
	var $helpers = array('Session', 'Html');

    function afterRender() {
        $view = ClassRegistry::getObject('view');
		$user_id = $this->Session->read('Auth.User.id');
		
		if (!empty($user_id)) {
			$login = 'Welcome, <a href="/profiles/profiles/view/user_id:'.$this->Session->read('Auth.User.id').'">'.$this->Session->read('Auth.User.username').'</a> -  <a href="/users/logout">Logout</a>';
		} else {
			$login = '<a href="/users/add">Sign Up</a> - <a href="/users/login">Sign In</a> ';
		}
			
		
    	$view->set('login_for_layout', $login);
		
    }

    function setValue($beforeValue = null, $afterValue = null, $renderDefault = true) {
        $this->beforeValue = $beforeValue;
        $this->renderDefault = $renderDefault;
        $this->afterValue = $afterValue;
    }
}
?>

=======
    var $value = '';
	var $helpers = array('Session', 'Html');

    function afterRender() {
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
>>>>>>> dev
