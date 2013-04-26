<?php
/**
 * Login Element 
 *
 * Used to display username welcome message when logged in, and a sign up and login link when not logged in. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.forms.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
  # this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
   # it allows a database driven way of configuring elements, and having multiple instances of that configuration.
  if(!empty($instance) && defined('__ELEMENT_USERS_LOGIN_FORM_'.$instance)) {
    extract(unserialize(constant('__ELEMENT_USERS_LOGIN_FORM_'.$instance)));
  } else if (defined('__ELEMENT_USERS_LOGIN_FORM')) {
    extract(unserialize(__ELEMENT_USERS_LOGIN_FORM));
  }
  
  $userId = $this->Session->read('Auth.User.id');  
  $formClass = !empty($formClass) ? $formClass : 'login-form';
  $divClass = !empty($divClass) ? $divClass : 'loginElement';
  $columnClass = !empty($columnClass) ? $columnClass : 'column';
  $holderClass = !empty($holderClass) ? $holderClass : 'holder';
  $rowClass = !empty($rowClass) ? $rowClass : 'rowClass';  
  $usernameLabel = !empty($usernameLabel) ? $usernameLabel : 'Username / Email';  
  $passwordLabel = !empty($passwordLabel) ? $passwordLabel : 'Password';  
  $submitLabel = !empty($submitLabel) ? $submitLabel : 'Login';
  $submitClass = !empty($submitClass) ? $submitClass : 'submit';
  $inputClass = !empty($inputClass) ? $inputClass : 'text';
  //$submitDiv = !empty($submitDiv) ? $submitDiv : false; // don't think it will work with the standard end() function
  $checkboxClass = !empty($checkboxClass) ? $checkboxClass : 'checkbox';
  $remember = isset($remember) ? $remember : true;
  $rememberLabel = !empty($rememberLabel) ? $rememberLabel : 'Keep me logged in';
  $forgotPasswordTitle = !empty($forgotPasswordTitle) ? $forgotPasswordTitle : 'Forgot Password?';
  $loggedElement = (isset($loggedElement) ? (!empty($loggedElement) ? $loggedElement : 'login_form_logged') : 'login_form_logged');
  $textWelcome = !empty($textWelcome) ? $textWelcome : 'Welcome : ';
  $linkRegisterText = !empty($linkRegisterText) ? $linkRegisterText : 'Register a new account';
  $linkRegisterUrl = !empty($linkRegisterUrl) ? $linkRegisterUrl : '/users/users/login';
  $linkClass = !empty($linkClass) ? $linkClass : 'loginLink';
  $linkIdUser = !empty($linkIdUser) ? $linkIdUser : 'useridLink';
  $textSeparator = !empty($textSeparator) ? $textSeparator : '-';
  $textLogOut = !empty($textLogOut) ? $textLogOut : 'Logout';
  $linkIdLogout = !empty($linkIdLogout) ? $linkIdLogin : 'logoutLink';
  
  $facebookId = $this->Session->read('Auth.User.facebook_id');
  
  if(!empty($facebookId)) {
    # use the facebook logout if it exists
    $logOutLink = $this->Facebook->logout(array('label' => $textLogOut, 'redirect' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'))); 
  } else {                                     
    $logOutLink = $this->Html->link($textLogOut, array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'), array('class' => $linkClass, 'id' => $linkIdLogout));
  }
  
  
    echo $this->Form->create('User', array(
      'url' => array(
        'controller' => 'users', 
        'action' => 'login', 
        'plugin' => 'users'
        ), 
      'class'=>$formClass
      )); 
 
      echo $this->Form->input('username', array('label' => $usernameLabel, 'class' => $inputClass, 'div' => $rowClass, 'placeholder' => $usernameLabel));
         
      echo $this->Form->input('password', array('label' => $passwordLabel, 'class' => $inputClass, 'div' => $rowClass, 'placeholder' => $passwordLabel));
                
      if (!empty($remember)) {
      	echo $this->Form->input('remember_me', array('label' => $rememberLabel, 'class' => $checkboxClass, 'div' => false, 'type' => 'checkbox'));
      }
     
      echo $this->Html->link($forgotPasswordTitle, array('plugin' => 'users', 'controller' => 'users', 'action' => 'forgot_password')); 
          
	  echo $this->Form->end(array('label' => $submitLabel, 'div' => array('class' => $submitClass)));
	  
	  echo $this->Html->link($linkRegisterText, $linkRegisterUrl);
 
