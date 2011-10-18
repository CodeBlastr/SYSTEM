<?php
/**
 * Users Registration View
 *
 * Where the look of the user registration form is controlled.  Please note that the default user role id is 3.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Make it so that admins can over ride the user_role_id with a link or something.  (ie. /register/user_role/administrators) -- actually no -- just give them a drop down.
 * @todo		  Move the constants to the controller, and send the user role id, and contact type from there.
 */
 ?>
 <div id="userRegister" class="user form">
  <h1><?php echo __('Register', true); ?></h1>
  <?php echo $this->Form->create('User', array('type' => 'file'));?>
  <?php echo $this->Form->input('Contact.id', array('type' => 'hidden')); ?>  
  <fieldset>
    <legend></legend>
    <?php 
		if(defined('__APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE')) { 
			echo $this->Form->input('User.contact_type', array('type' => 'hidden', 'value' => __APP_DEFAULT_USER_REGISTRATION_CONTACT_TYPE));
		} else {
			echo $this->Form->input('User.contact_type', array('type' => 'hidden', 'value' => 'person'));
		}
		
		echo !empty($userRoleId) ? $this->Form->hidden('User.user_role_id', array('value' => $userRoleId)) : $this->Form->input('User.user_role_id');
		echo $this->Form->input('User.full_name', array('label' => 'Name'));
		#echo $this->Form->input('User.email', array('value' => ''));
		#echo $this->Form->input('User.avatar', array('type' => 'file', 'label' => 'Avatar'));
		echo $this->Form->input('User.username', array('label' => 'Email'));
		echo $this->Form->input('User.password', array('value' => ''));
		echo $this->Form->input('User.confirm_password', array('type' => 'password', 'value' => '', 'label' => 'Confirm'));
		if(isset($this->request->params['named']['referal_code']) && !empty($this->request->params['named']['referal_code'])) {
		 	echo $this->Form->input('User.referal_code', array('type' => 'hidden', 'value' => $this->request->params['named']['referal_code']));
		}
	?>
  </fieldset>  
  <?php echo $this->Form->end('Submit');?> 
</div>
<?php 
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('Login'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'login')),
			$this->Html->link(__('Logout'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')),
			 )
		),
	)));
?>
