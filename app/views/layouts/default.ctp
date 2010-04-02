<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
		<?php __(' : The Open Source Killer Business App : Zuha'); ?>
	</title>
	<?php
		echo $html->meta('icon');
		echo $html->css('screen');
		echo $html->css('modalbox');
		echo $html->css('datepicker');
		echo $javascript->link('datepicker');
		echo $javascript->link('prototype');
		echo $javascript->link('scriptaculous');
		echo $javascript->link('effects');
		echo $javascript->link('controls');
		/* This might work instead, haven't tested
		echo $javascript->link('scriptaculous?load=effects,controls'); */
		echo $javascript->link('modalbox');
		echo $javascript->link('tabs');
		echo $javascript->link('swfobject');
		echo $scripts_for_layout;  // to use this specify false for the 'in-line' argument when you put javascript into views -- that will cause your view javascript to be pushed to the <head> ie. $javascript->codeBlock($functionForExemple, array('inline'=>false));
	?>
</head>
<body class="<?php echo $this->params['controller']; ?>">
	<div id="container">
		<div id="header">
			<div id="loadingimg" style="display: none;"><?php echo $html->image('ajax-loader.gif'); ?></div>
			<p><?php if($session->read('Auth.User')) : __('Your Username : '); echo $session->read('Auth.User.username'); __(' - '); echo $html->link(__('Logout', true), '/users/logout'); else : echo $html->link(__('Login', true), '/users/login'); endif; ?>
			</p>
			<div class="nav">
				<ul class="crm">
					<li class="crm"><?php echo $html->link(__('Contacts', true), array('controller' => 'contacts', 'admin' => 1)); ?>
						<ul>
							<li><?php echo $html->link(__('People', true), array('controller' => 'contact_people', 'admin' => 1));  ?></li>
							<li><?php echo $html->link(__('Companies', true), array('controller' => 'contact_companies', 'admin' => 1)); ?></li>
						</ul>
					</li>
					<li class="pm"><?php echo $html->link(__('Projects', true), array('controller' => 'projects', 'admin' => 1)); ?>
						<ul>
							<li><?php echo $html->link(__('Issues', true), array('controller' => 'project_issues', 'action' => 'index', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Quotes', true), array('controller' => 'quotes', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Timesheets', true), array('controller' => 'timesheets', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Tickets', true), array('controller' => 'tickets', 'admin' => 1)); ?></li>
						</ul>
					</li>
					<li class="ecom"><?php echo $html->link(__('Orders', true), array('controller' => 'orders', 'admin' => 1)); ?>
						<ul>
							<li><?php echo $html->link(__('Catalog', true), array('controller' => 'catalogs', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Invoices', true), array('controller' => 'invoices', 'admin' => 1)); ?></li>
						</ul>
					</li>
					<li class="site"><?php echo $html->link(__('WebPages', true), array('controller' => 'webpages', 'admin' => 1)); ?>
						<ul>
							<li><?php echo $html->link(__('Pages', true), array('controller' => 'webpages', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Blogs', true), array('controller' => 'blogs', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('FAQ\'s', true), array('controller' => 'faqs', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Wikis', true), array('controller' => 'wikis', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Media', true), array('controller' => 'media', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Tags', true), array('controller' => 'tags', 'admin' => 1)); ?></li>
						</ul>
					</li>
					<li class="ads"><?php echo $html->link(__('Campaigns', true), array('controller' => 'campaigns', 'admin' => 1)); ?>
						<ul>
							<li><?php echo $html->link(__('Campaigns', true), array('controller' => 'campaigns', 'admin' => 1)); ?></li>
						</ul>
					</li>
					<li class="admin"><?php echo $html->link(__('Dashboard', true), array('controller' => 'settings', 'admin' => 1)); ?>
						<ul>
							<li><?php echo $html->link(__('Users', true), array('controller' => 'users', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Reports', true), array('controller' => '', 'admin' => 1)); ?></li>
							<li><?php echo $html->link(__('Settings', true), array('controller' => 'settings', 'admin' => 1)); ?></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	  	<div id="contentwrap">
			<div id="content">
				<div id="col1">
				<div id="beforecontent"></div> 
					<?php $session->flash(); ?>
					<?php echo $content_for_layout; ?>
				<div id="aftercontent"></div>
				</div>
				<div id="col2">
					<ul>
						<?php echo $menu_for_layout; ?>
					</ul>
				</div>
			</div>
	  	</div>
		<div id="footer">
			<?php echo $html->link($html->image('zuha.power.gif', array('alt'=> __("The Open Source Killer Business App : Zuha", true), 'border'=>"0")),	'http://www.zuha.com/',	array('target'=>'_blank'), null, false);?>
		</div>
	</div>
	<?php // echo $cakeDebug; ?>
</body>
</html>