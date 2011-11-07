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
	if(!empty($instance) && defined('__ELEMENT_USERS_LOGIN_FORM_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_USERS_LOGIN_FORM_'.$instance)));
	} else if (defined('__ELEMENT_USERS_LOGIN_FORM')) {
		extract(unserialize(__ELEMENT_USERS_LOGIN_FORM));
	}
	
	$formClass = !empty($formClass) ? $formClass : 'login-form';
	$divClass = !empty($divClass) ? $divClass : 'loginElement';
	
	echo $this->Form->create('User', array('url'=>array('controller'=>'users', 'action'=>'login', 'plugin'=>'users'), 'class'=>$formClass));
?>

	<fieldset>
		<div class="column">
			<label for="UserUsername">Email</label>
			<div class="holder">
				<?php echo $this->Form->input('username', array('label'=>false, 'class'=>'text', 'div'=>'row')); ?>
				<div class="row">
					<input id="check" class="checkbox" type="checkbox" checked="checked" />
					<label for="check">Keep me logged in</label>
				</div>
			</div>
		</div>
		<div class="column">
			<label for="UserPassword">Password</label>
			<div class="holder">			
				<?php echo $this->Form->input('password', array('label'=>false, 'class'=>'text', 'div'=>'row')); ?>

				<div class="row">
					<?php echo $this->Html->link('Forgot Password?', array('plugin' => 'users', 'controller' => 'users', 'action' => 'forgot_password')); ?>
				</div>
			</div>
		</div>
		<?php echo $this->Form->submit('Login', array('class'=>'submit', 'div'=>false)); ?> 
	</fieldset>
<?php echo $this->Form->end(); ?>
