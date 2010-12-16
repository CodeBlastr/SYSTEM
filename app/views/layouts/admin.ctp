<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; __(' : Zuha Business Management'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');		
		echo $this->Html->css('admin');		
		echo $this->Html->css('jquery-ui-1.8.1.custom');
		echo $this->Html->script('jquery-1.4.2.min');
		echo $this->Html->script('jquery-ui-1.8.custom.min');
		echo $this->Html->script('jquery.jeditable');
		echo $scripts_for_layout;  // to use this specify false for the 'in-line' argument when you put javascript into views -- that will cause your view javascript to be pushed to the <head> ie. $javascript->codeBlock($functionForExemple, array('inline'=>false));

	?>
</head>
<body class="<?php echo $this->params['controller']; ?><?php if($session->read('Auth.User')) : __(' authorized'); else : __(' restricted'); endif; ?>">
	<div id="container">
		<div id="header">				
			<div id="loadingimg" style="display: none;"><?php echo $html->image('ajax-loader.gif'); ?></div>
            <a href="/admin/" id="logo"><p>Collaborative Business Management</p><p> Version : <?php echo __SYS_ZUHA_DB_VERSION; ?></p></a>
            
            <div class="login">
			<?php 
			if($session->read('Auth.User')) { 
			?>
				<p>Welcome
            	<?php __($session->read('Auth.User.username'));	?>
				<?php __($html->link(__($html->tag('span', 'log out'), true), array('plugin' => null, 'controller' => 'users', 'action' => 'logout'), array('escape' => false, 'class' => 'button'))); ?>
                </p>
            <?php
			} else { 
			?>
				<?php __($html->link(__($html->tag('span', 'sign-up', array('class' => 'button')), true), array('plugin' => null, 'controller' => 'users', 'action' => 'add'), array('escape' => false, 'class' => 'button'))); ?>
                <?php __($html->link(__($html->tag('span', 'sign-in', array('class' => 'button')), true), array('plugin' => null, 'controller' => 'users', 'action' => 'login'), array('escape' => false, 'class' => 'button'))); ?>
                </p>
            <?php
			};
			?>
            </div>
            <div id="searches-index" class="search">
				<?php echo $form->create(null, array('url' => array('plugin' => 'searches', 'controller' => 'searches', 'action' => 'index', 'admin' => 0), 'type' => 'get')).$form->input('q', array('label' => 'Search ', 'width' => '30%')).$form->hidden('t', array( 'value' => '1' )).$form->submit().$form->end(); ?>
            </div>
            
			<div id="navtabs">
				<ul>
					<li><a href="#navtabs-1">Dashboard</a></li>
					<li><a href="#navtabs-2">Contacts</a></li>
					<li><a href="#navtabs-3">Projects</a></li>
					<li><a href="#navtabs-4">ECommerce</a></li>
					<li><a href="#navtabs-5">Content</a></li>
					<li><a href="#navtabs-6">Marketing</a></li>
				</ul>
				<div id="navtabs-1">
					<a href="/"><?php echo __('Public Home', true); ?></a>
					<?php echo $html->link(__('Users', true), array('plugin' => null, 'controller' => 'users', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('Permissions', true), array('plugin' => 'permissions', 'controller' => 'acores', 'action' => 'index', 'admin' => 1)); ?>
					<?php # echo $html->link(__('Search', true), array('plugin' => 'searches', 'controller' => 'searches', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('Notifications', true), array('plugin' => 'notifications', 'controller' => 'notification_templates', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('Forms', true), array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('Settings', true), array('plugin' => null, 'controller' => 'settings', 'admin' => 1)); ?>
				</div>
				<div id="navtabs-2">
					<?php echo $html->link(__('All Contacts', true), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('People', true), array('plugin' => 'contacts', 'controller' => 'contact_people', 'action' => 'index', 'admin' => 1));  ?>
					<?php echo $html->link(__('Companies', true), array('plugin' => 'contacts', 'controller' => 'contact_companies', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('Opportunities', true), array('plugin' => 'contacts', 'controller' => 'contact_opportunities', 'action' => 'my', 'admin' => 1)); ?>
				</div>
				<div id="navtabs-3">
					<?php echo $html->link(__('Projects', true), array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('Timesheets', true), array('plugin' => null, 'controller' => 'timesheets', 'admin' => 1)); ?>
					<?php echo $html->link(__('Tickets', true), array('plugin' => null, 'controller' => 'tickets', 'admin' => 1)); ?>
					<?php echo $html->link(__('Priorities', true), array('plugin' => 'priorities', 'controller' => 'priorities', 'action' => 'my', 'admin' => 1)); ?>
				</div>
				<div id="navtabs-4">
					<?php echo $html->link(__('Orders', true), array('plugin' => 'orders', 'controller' => 'orders', 'admin' => 1)); ?>
					<?php echo $html->link(__('Catalogs', true), array('plugin' => 'catalogs', 'controller' => 'catalogs', 'admin' => 1)); ?>
					<?php echo $html->link(__('Categories', true), array('plugin' => 'categories', 'controller' => 'categories', 'admin' => 1)); ?>
					<?php echo $html->link(__('Products', true), array('plugin' => 'catalogs', 'controller' => 'catalog_items', 'admin' => 1)); ?>
					<?php echo $html->link(__('Invoices', true), array('plugin' => null, 'controller' => 'invoices', 'admin' => 1)); ?>
				</div>
				<div id="navtabs-5">
					<?php echo $html->link(__('Pages', true), array('plugin' => null, 'controller' => 'webpages', 'admin' => 1)); ?>
					<?php echo $html->link(__('Blogs', true), array('plugin' => null, 'controller' => 'blogs', 'action' => 'index', 'admin' => 1)); ?>
					<?php #echo $html->link(__('FAQ\'s', true), array('plugin' => null, 'controller' => 'faqs', 'admin' => 1)); ?>
					<?php echo $html->link(__('Wikis', true), array('plugin' => null, 'controller' => 'wikis', 'admin' => 1)); ?>
					<?php #echo $html->link(__('Forums', true), array('plugin' => 'forums', 'controller' => 'forums', 'action' => 'index', 'admin' => 1)); ?>
					<?php echo $html->link(__('Media', true), '/ckfinder/ckfinder.html'); ?>
					<?php echo $html->link(__('Tags', true), array('plugin' => null, 'controller' => 'tags', 'admin' => 1)); ?>
				</div>
				<div id="navtabs-6">
					<?php echo $html->link(__('Notifications', true), array('controller' => 'notification_conditions', 'action' => 'index', 'admin' => 1)); ?>
				</div>
			</div>
		</div>
	  	<div id="contentwrap">
			<div id="content">
            	<a id="toggleSidebar"></a>
				<div id="col1">
				<div id="beforecontent"></div> 
					<?php echo $session->flash(); ?>
   					<?php echo $session->flash('auth'); ?>
					<?php echo $content_for_layout; ?>
				<div id="aftercontent"></div>
				</div>
				<?php echo (!empty($menu_for_layout) ? $menu_for_layout : ''); ?>
			</div>
	  	</div>
		<div id="footer">
			<?php echo $html->link($html->image('zuha.power.gif', array('alt'=> __("The Open Source Killer Business App : Zuha", true), 'border'=>"0")),	'http://www.zuha.com/',	array('target'=>'_blank', 'escape' => false), null, false);?>
		</div>
	</div>
<?php echo $this->element('sql_dump'); ?>  
</body>
</html>