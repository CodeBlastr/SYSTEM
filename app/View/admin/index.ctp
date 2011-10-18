<?php
/**
 * Admin Dashboard Index View
 *
 * This view is the hub for the admin section of the site. Will be used as the launchpad for site administration.
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
 * @subpackage    zuha.app.views.admin
 * @since         Zuha(tm) v 0.0009
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>
<?php 
if (!empty($upgradeDB)) {
?>

<div id="databaseUpgrades">
  <h2>Database Upgrade Needed</h2>
  <h6>The following database queries should run.</h6>
  <?php 
	echo $this->Form->create('Admin', array('url' => '/admin/')); 	
	$n = 0;
	foreach ($upgradeDB as $query) { 
	?>
  <p><?php echo $query; ?></p>
  <?php
		echo $this->Form->input('Query.'.$n.'.data', array('type' => 'hidden', 'value' => $query)); 
		$n++;
	}
	echo $this->Form->end('Run Upgrade Queries');
	?>
</div>
<?php 
}

if (!empty($previousUpgrade)) {
?>
<div id="databaseUpgrades">
  <h2>Upgrade Queries Ran</h2>
  <h6>The following database queries we're just ran.</h6>
  <?php 
	echo $this->Form->create('Admin', array('url' => '/admin/')); 	
	$n = 0;
	foreach ($previousUpgrade as $query) { ?>
  <p><?php echo $query; ?></p>
  <?php }	?>
</div>
<?php 
}
?>
<!-- /homeheader -->
<div class="accordion">
  <ul>
    <li data-role="list-divider"> <a href="#"><span>Design</span></a></li>
  </ul>
  <ul>
    <li><a href="/webpages/webpages/index/type:template">Site Templates</a></li>
    <li><a href="/webpages/webpages/index/type:element/">Global Boxes</a></li>
    <li><a href="/webpages/webpage_csses">Css Styles</a></li>
    <li class="separator"><a href="/webpages/webpage_jses">Javascript</a></li>
  </ul>
  <ul>
    <li data-role="list-divider"> <a href="#"><span>Content</span></a></li>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Webpages', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'page_content')); ?></li>
    <li><?php echo $this->Html->link('Image Manager', array('controller' => 'admin', 'action' => 'files_image')); ?></li>
    <li><?php echo $this->Html->link('Document Manager', array('controller' => 'admin', 'action' => 'files_files')); ?></li>
    <li><?php echo $this->Html->link('Comments', array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'index')); ?></li>
    <!--li class="title">Feedback</li>
    <li>Ratings (coming soon)</li-->
    <li><?php echo $this->Html->link('Invites', array('plugin' => 'invite', 'controller' => 'invites', 'action' => 'invitation')); ?></li>
    <li><?php echo $this->Html->link('Blogs', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Faqs', array('plugin' => 'faqs', 'controller' => 'faqs', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Maps', array('plugin' => 'maps', 'controller' => 'maps', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Galleries', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Wikis', array('plugin' => 'wikis', 'controller' => 'wikis', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Categories', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Enumerations', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index')); ?></li>
  </ul>
  <ul>
    <li> <a href="#"><span>Contacts</span></a></li>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Contacts', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'index')); ?></li>
    <li><!--a href="/contacts/contacts/tasks"-->Leads (coming soon)</li>
    <li><!--a href="/contacts/contacts/messages/"-->Activities (coming soon)</li></ul>
  <ul>
    <li> <a href="#"><span>Sales</span></a></li>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Estimates', array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Invoices', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Orders', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index')); ?></li>
  </ul>
  <ul>
    <li> <a href="#"><span>Marketing</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Conditions', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Workflows', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Analytics', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'dashboard')); ?></li>
    <li><?php echo $this->Html->link('Reports', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'index')); ?></li>
  </ul>
  <ul>
    <li> <a href="#"><span>Support</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Projects', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Timesheets', array('plugin' => 'timesheets', 'controller' => 'timesheets', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Tasks', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'my')); ?></li>
    <li><?php echo $this->Html->link('Tickets', array('plugin' => 'tickets', 'controller' => 'tickets', 'action' => 'index')); ?></li>
  </ul>
  <ul>
    <li> <a href="#" title="Users"><span>Users</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('User Roles', array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Groups', array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Statuses', array('plugin' => 'users', 'controller' => 'user_statuses', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Walls', array('plugin' => 'users', 'controller' => 'user_walls', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Messages', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index')); ?></li>
  </ul>
  <ul>
    <li> <a href="#" title="Content"><span>Extend</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Settings', array('plugin' => null, 'controller' => 'settings', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Custom Forms', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Conditions', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Workflows', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index')); ?></li>
  </ul>
</div>
