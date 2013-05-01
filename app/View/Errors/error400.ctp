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
 
echo __('<div class="row">');
if (CakeSession::read('Auth.User.user_role_id') == 1) {
	echo __('<div class="hero-unit pull-left span5"><h1><small style="vertical-align: middle;">Page not found but...<br /></small>You\'re special!</h1><br /><p>%s</p></div>', $this->Html->link(__('Add the page : %s/%s', $_SERVER['HTTP_HOST'], $url), array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'add', 'content', 'alias' => $url), array('class' => 'btn btn-success')));
}

$content = !empty($content) ? $content : __('<h2>%s</h2><p class="error">The requested address <strong>\'%s\'</strong> was not found on this server.</p>', $name, $url);
echo __('<div class="span4"> %s </div>', $content);


if (Configure::read('debug') > 0) {
	echo $this->element('exception_stack_trace');
}
echo __('</div>');

// set the contextual menu items
//$this -> set('context_menu', array('menus' => array( array('heading' => 'Errors', 'items' => array($this -> Html -> link(__('Sitemap', true), array('plugin' => 'sitemaps', 'controller' => 'sitemaps', 'action' => 'index'), array('class' => 'index')), )), )));
