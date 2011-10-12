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
  	<ul class="accordion">
        
        
        <li data-role="list-divider"> <a href="#"><span>Design</span></a></li>
       	<li class="title">Design</li>
        <li><a href="/webpages/webpages/index/type:template">Templates</a></li>
        <li><a href="/webpages/webpages/index/type:element/">Elements</a></li>
        <li><a href="/webpages/webpage_csses">Css Files</a></li>
        <li class="separator"><a href="/webpages/webpage_jses">Js Files</a></li>
        <li class="title">Files</li>
        <li><a href="/admin/admin/files_image">Images</a></li>
        <li><a href="/admin/admin/files_files">Documents</a></li>
        
        
        <li data-role="list-divider"> <a href="#"><span>Content</span></a></li>
        <li><a href="/webpages/webpages/index/type:page_content/">Webpages</a></li>
        <li><a href="/admin/admin/files_image">Images</a></li>
        <li class="separator"><a href="/admin/admin/files_files">Documents</a></li>
        <li class="separator"><a href="/admin/forms">Custom Forms</a></li>
        
        <!--li class="title">Feedback</li-->
        <li><a href="/admin/comments">Comments</a></li>
        <li>Ratings (coming soon)</li>
        <li class="separator"><!--a href="/invite/invites/invitation"-->Invites (coming soon)</li>
        
        <!--li class="title">Extended</li-->
        <li><a href="/blogs">Blogs</a></li>
                <li><a href="/admin/faqs">Faqs</a></li>
                <li><a href="/admin/forum/forum_home">Forums</a></li>
                <li><a href="/admin/maps">Maps</a></li>
                <li><a href="/admin/galleries">Galleries</a></li>
                <li class="separator"><a href="/admin/wikis">Wikis</a></li>
        <!--li class="title">Labels</li-->
                <li><a href="/admin/categories">Categories</a></li>
                <li><a href="/admin/tags">Tags</a></li>
                <li><a href="/admin/enumerations">Enumerations</a></li>
                
                
                
        <li data-role="list-divider"> <a href="#"><span>Sales</span></a></li>
        <!--li class="title">Contacts</li-->
        <li><a href="/contacts">All Contacts</a></li>
        <li><a href="/contacts/contact_people">People</a></li>
        <li class="separator"><a href="/contacts/contact_companies">Companies</a></li>
        
        <!--li class="title">Tracking</li-->
        <li><!--a href="/contacts/contacts/tasks"-->Leads (coming soon)</li>
        <li class="separator"><!--a href="/contacts/contacts/messages/"-->Activities (coming soon)</li>
        
        <!--li class="title">Sales</li-->
        <li><a href="/estimates">Estimates</a></li>
        <li><a href="/invoices">Invoices</a></li>
        <li class="separator"><a href="/orders/order_transactions/">Orders</a></li>
        
        <!--li class="title">Catalogs</li-->
                <li class="separator"><a href="/catalogs/catalogs/dashboard">Dashboard</a></li>
              </ul>
        </li>
        <li> <a href="/admin/reports/reports/dashboard"><span>Marketing</span></a>
              <ul>
                <li class="title">Tools</li>
                <li><a href="/admin/notifications/notification_templates">Notifications</a></li>
                <li><a href="/admin/conditions">Conditions</a></li>
                <li class="separator"><a href="/workflows">Workflows</a></li>
              </ul>
              <ul>
                <li class="title">Reporting</li>
                <li><a href="/admin/reports">Analytics</a></li>
                <li class="separator"><a href="/admin/reports">Reports</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a href="#"><span>Support</span></a>
              <ul>
                <li class="title">Projects</li>
                <li><a href="/projects">Projects</a></li>
                <li><a href="/timesheets">Timesheets</a></li>
                <li><a href="/tasks/tasks/my">Tasks</a></li>
              </ul>
              <ul>
                <li class="title">Support</li>
                <li class="separator"><a href="/admin/tickets">Tickets</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a href="#" title="Users"><span>Users</span></a>
              <ul>
                <li class="title">Users</li>
                <li><a href="/users">All Users</a></li>
                <li class="separator"><a href="/users/user_roles">User Roles</a></li>
              </ul>
              <ul>
                <li class="title">Social</li>
                <li><a href="/users/user_groups">Groups</a></li>
                <li><a href="/users/user_statuses">Statuses</a></li>
                <li><a href="/users/user_walls">Walls</a></li>
                <li class="separator"><a href="/messages">Messages</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a href="/admin/webpages" title="Content"><span>Extend</span></a>
              <ul>
                <li class="title">App Builder</li>
                <li><a href="/privileges">Privileges</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li><a href="/admin/forms">Custom Forms</a></li>
                <li><a href="/admin/conditions">Conditions</a></li>
                <li class="separator"><a href="/workflows">Workflows</a></li>
              </ul>
        </li>
      </ul>
  
  		
    <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
      <li data-role="list-divider">Content Management</li>
      <li><a href="/admin/projects">Projects</a></li>
      <li><a href="content/dashboard/write.html">Write</a></li>
      <li><a href="content/dashboard/pages.html">Pages</a></li>
      <li><a href="content/dashboard/media.html">Media</a></li>
      <li><a href="content/dashboard/settings.html">Settings</a></li>
    </ul>
    <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
      <li data-role="list-divider">User</li>
      <li><a href="content/user/">Messages</a></li>
      <li><a href="content/user/">Profile</a></li>
      <li><a href="content/user/">Settings</a></li>
      <li><a href="content/user/">Add user</a></li>
      <li><a href="content/user/users.html">All users</a></li>
    </ul>
    <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
      <li data-role="list-divider">Statistics</li>
      <li><a href="content/statistics/all.html">All</a><span class="ui-li-count">21254</span></li>
      <li><a href="content/statistics/day.html">Day</a><span class="ui-li-count">42</span></li>
      <li><a href="content/statistics/month.html">Month</a><span class="ui-li-count">631</span></li>
      <li><a href="content/statistics/year.html">Year</a><span class="ui-li-count">1932</span></li>
    </ul>
  </div>
  <!-- /content -->
</div>
<!-- /page -->
</body>
</html>