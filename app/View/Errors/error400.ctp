<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>


<?php 
$userRole = CakeSession::read('Auth.User.user_role_id');
if ($userRole == 1) { ?>

<p class="message">Page Not Found : Its highly recommended that you create a custom error message. <?php echo $this->Html->link('Click here to add', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'add', 'alias' => 'error')); ?>. <br /><br /><small>Because you are the admin you can add a custom error page.  Once you add a custom error page users who are not admins will see the new error page you create when they request a url on your site that does not exist.  Currently they see the page you are looking at now, without this secret admin message displayed.   <br /><br />Also, as the admin, after you create a custom error page, you will be able to add new pages to your site by simply visiting the url of the page you want to exist that does not already exist.</small></p>
<?php } ?>

<h2><?php echo $name; ?></h2>
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php printf(__d('cake', 'The requested address %s was not found on this server.'), "<strong>'{$url}'</strong>"); ?>
</p>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Errors',
		'items' => array(
			$this->Html->link(__('Sitemap', true), array('plugin' => 'sitemaps', 'controller' => 'sitemaps', 'action' => 'index'), array('class' => 'index')),
			)
		),
	))); ?>
