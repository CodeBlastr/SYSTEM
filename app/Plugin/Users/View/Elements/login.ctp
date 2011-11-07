<?php
/**
 * Login Element 
 *
 * Used to display username welcome message when logged in, and a sign up and login link when not logged in. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.forms.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
	# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
 	# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	if(!empty($instance) && defined('__ELEMENT_USERS_LOGIN_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_USERS_LOGIN_'.$instance)));
	} else if (defined('__ELEMENT_USERS_LOGIN')) {
		extract(unserialize(__ELEMENT_USERS_LOGIN));
	}
	
	# set up defaults
	$userId = $this->Session->read('Auth.User.id');
	$divId = !empty($divId) ? $divId : 'loginElement';
	$divClass = !empty($divClass) ? $divClass : 'loginElement';
	$textWelcome = !empty($textWelcome) ? $textWelcome : 'Welcome : ';
	$textRegister = !empty($textRegister) ? $textRegister : 'Register';
	$linkRegisterUrl = !empty($linkRegisterUrl) ? $linkRegisterUrl : array('plugin' => 'users', 'controller' => 'users', 'action' => 'register');
	$textLogIn = !empty($textLogIn) ? $textLogIn : 'Login';
	$linkLoginUrl = !empty($linkLoginUrl) ? $linkLoginUrl : array('plugin' => 'users', 'controller' => 'users', 'action' => 'login');
	$textLogOut = !empty($textLogOut) ? $textLogOut : 'Logout';
	$textSeparator = !empty($textSeparator) ? $textSeparator : '-';
	$linkClass = !empty($linkClass) ? $linkClass : 'loginLink';
	$linkIdUser = !empty($linkIdUser) ? $linkIdUser : 'useridLink';
	$linkIdLogin = !empty($linkIdLogin) ? $linkIdLogin : 'useridLink';
	$linkIdLogout = !empty($linkIdLogout) ? $linkIdLogin : 'logoutLink';
	$linkIdSignUp = !empty($linkIdSignUp) ? $linkIdSignUp : 'signupLink';
	$linkIdSignIn = !empty($linkIdSignIn) ? $linkIdSignIn : 'signinLink';
	$facebookId = $this->Session->read('Auth.User.facebook_id');
	
		if(!empty($facebookId)) {
			# use the facebook logout if it exists
			$logOutLink = $this->Facebook->logout(array('label' => $textLogOut, 'redirect' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'))); 
		} else {																	   
			$logOutLink = $this->Html->link($textLogOut, array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'), array('class' => $linkClass, 'id' => $linkIdLogout));
		}
?>

<div id="<?php echo $divId; ?>" class="<?php echo $divClass; ?>">
	<ul>
	<?php if (!empty($userId)) { ?>
			<li id="usernameLi"><span class="usernameWelcome"><?php echo $textWelcome; ?></span><span class="usernameName"><?php echo $this->Html->link($this->Session->read('Auth.User.username'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'my'), array('class' => $linkClass, 'id' => $linkIdUser, 'checkPermissions' => true)); ?></span></li>
            <li id="loginSeparatorLi"><?php echo $textSeparator; ?></li>
            <li id="loginLogoutLi"><?php echo $logOutLink; ?></li>
    <?php } else { ?>
			<li id="loginRegisterLi"><?php echo $this->Html->link($textRegister, $linkRegisterUrl, array('class' => $linkClass, 'id' => $linkIdSignUp)); ?></li>
            <li id="loginSeparatorLi"><span id="loginSeparator"><?php echo $textSeparator; ?></span></li>
            <li id="loginLoginLi"><?php echo $this->Html->link($textLogIn, $linkLoginUrl, array('class' => $linkClass, 'id' => $linkIdSignIn)); ?></li>
            <?php if (defined('__APP_LOAD_APP_HELPERS') && strpos(__APP_LOAD_APP_HELPERS, 'acebook')) { echo '
            <li>'.$textSeparator.'</li><li>'.$this->Facebook->login(array('perms' => 'email,publish_stream')).'</li>'; } ?>
    <?php } ?>
	</ul>
</div>