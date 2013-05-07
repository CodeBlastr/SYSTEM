<div class="row">
	<?php 
	if (CakeSession::read('Auth.User.user_role_id') == 1) {
		echo __('<div class="hero-unit pull-left span5"><h1><small style="vertical-align: middle;">Page not found but...<br /></small>You\'re special!</h1><br /><p>%s</p></div>', $this->Html->link(__('Add page : \'%s\'', $url), array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'add', 'content', 'alias' => $url), array('class' => 'btn btn-success', 'style' => 'display: block;')));
	}
	
	$content = !empty($content) ? $content : __('<h2>%s</h2><p class="error">The requested address <strong>\'%s\'</strong> was not found on this server.</p>', $name, $url);
	echo __('<div class="span4"> %s </div>', $content);
	
	
	if (Configure::read('debug') > 0) {
		echo $this->element('exception_stack_trace');
	} ?>
</div>

<?php
// set the contextual menu items
//$this -> set('context_menu', array('menus' => array( array('heading' => 'Errors', 'items' => array($this -> Html -> link(__('Sitemap', true), array('plugin' => 'sitemaps', 'controller' => 'sitemaps', 'action' => 'index'), array('class' => 'index')), )), )));
