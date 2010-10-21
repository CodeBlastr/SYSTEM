<?php

class LoginHelper extends AppHelper {
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

