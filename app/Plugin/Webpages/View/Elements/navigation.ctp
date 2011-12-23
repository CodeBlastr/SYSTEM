<?php $requestUrl = strpos($this->request->url, '/') === 0 ? $this->request->url : '/'.$this->request->url; ?>
<div id="slidedock">
  <div id="slidedock_content">
      <ul>
      	<li><a class="dock_btn edit_button" id="edit_button" title="On edit mode"><span>Edit Mode : Off</span></a></li>
	    <li><a href="<?php echo '/'.$this->Session->read('Auth.User.view_prefix').$requestUrl; ?>"><span><?php echo $this->Session->read('Auth.User.view_prefix'); ?> This Page</span></a></li>
        
    <li><?php echo $this->Html->link('<span>Dashboard</span>', array('plugin' => null, 'controller' => 'admin', 'action' => 'index'), array('escape' => false, 'title' => 'Privileges, Settings, Workflows, Conditions, Custom Forms', 'id' => 'navAdmin')); ?>
              <ul>
                <li><?php echo $this->Html->link('<span>Privileges</span>', array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index'), array('escape' => false, 'title' => 'Manage user role access to sections.')); ?></li>
                <li><?php echo $this->Html->link('<span>Settings</span>', array('plugin' => null, 'controller' => 'settings', 'action' => 'index'), array('escape' => false, 'title' => 'Set your custom configuration options.')); ?></li>
                <li><?php echo in_array('Forms', CakePlugin::loaded()) ? $this->Html->link('<span>Forms</span>', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index'), array('escape' => false, 'title' => 'Customize forms and manage database fields.')) : null ; ?></li>
                <li><?php echo $this->Html->link('<span>Conditions</span>', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index'), array('escape' => false, 'title' => 'Advanced website automation by matching conditions to future actions.')); ?></li>
                <li><?php echo $this->Html->link('<span>Workflows</span>', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index'), array('escape' => false, 'title' => 'The actions your conditions will force to happen.')); ?></li>
              </ul>
    
    
    </li>
    <li><?php echo $this->Html->link('<span>Theme</span>', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'theme'), array('escape' => false, 'title' => 'Templates, CSS, Javascript', 'id' => 'navTheme')); ?></li>
    <li><?php echo $this->Html->link('<span>Content</span>', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'id' => 'navContent')); ?></li>
    <li><?php echo $this->Html->link('<span>Contacts</span>', array('admin' => true, 'plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Leads, Opportunities', 'id' => 'navContacts')); ?></li>
    <li><?php echo $this->Html->link('<span>Products</span>', array('admin' => true, 'plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li>
    <li><?php echo $this->Html->link('<span>Billing</span>', array('admin' => true, 'plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li>
    <li><?php echo $this->Html->link('<span>Support</span>', array('admin' => true, 'plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets', 'id' => 'navSupport')); ?></li>
    <li><?php echo $this->Html->link('<span>Users</span>', array('admin' => true, 'plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></li>
    <li><?php echo $this->Html->link('<span>Reports</span>', array('admin' => true, 'plugin' => 'reports', 'controller' => 'reports', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Report Builder, Analytics', 'id' => 'navReports')); ?></li>
        <li> <a href="#"><span>Design</span></a>
          <ul>
                <li class="title">Design</li>
                <li><a href="/admin/webpages/webpages/index/type:template">Templates</a></li>
                <li><a href="/webpages/webpages/index/type:element/">Elements</a></li>
                <li><a href="/webpages/webpage_csses">Css Files</a></li>
                <li><a href="/webpages/webpage_jses">Js Files</a></li>
                <li class="title">Files</li>
                <li><a href="/admin/admin/files_image">Images</a></li>
                <li><a href="/admin/admin/files_files">Documents</a></li>
              </ul>
        </li>
        <li> <a href="#"><span>Content</span></a>
              <ul>
                <li class="title">Content</li>
                <li><a href="/webpages/webpages/index/type:page_content/">Webpages</a></li>
                <li><a href="/admin/admin/files_image">Images</a></li>
                <li><a href="/admin/admin/files_files">Documents</a></li>
                <li><a href="/admin/forms">Custom Forms</a></li>
                <li class="title">Feedback</li>
                <li><a href="/admin/comments">Comments</a></li>
                <li>Ratings (coming soon)</li>
                <li><!--a href="/invite/invites/invitation"-->Invites (coming soon)</li>
              </ul>
              <ul>
                <li class="title">Extended</li>
                <li><a href="/blogs">Blogs</a></li>
                <li><a href="/admin/faqs">Faqs</a></li>
                <li><a href="/admin/forum/forum_home">Forums</a></li>
                <li><a href="/admin/maps">Maps</a></li>
                <li><a href="/admin/galleries">Galleries</a></li>
                <li><a href="/admin/wikis">Wikis</a></li>
                <li class="title">Labels</li>
                <li><a href="/admin/categories">Categories</a></li>
                <li><a href="/admin/tags">Tags</a></li>
                <li><a href="/admin/enumerations">Enumerations</a></li>
              </ul>
        </li>
        <li> <a href="#"><span>Sales</span></a>
              <ul>
                <li class="title">Contacts</li>
                <li><a href="/contacts">All Contacts</a></li>
                <li><a href="/contacts/contact_people">People</a></li>
                <li><a href="/contacts/contact_companies">Companies</a></li>
                <li class="title">Tracking</li>
                <li><!--a href="/contacts/contacts/tasks"-->Leads (coming soon)</li>
                <li><!--a href="/contacts/contacts/messages/"-->Activities (coming soon)</li>
                <li class="title">Sales</li>
                <li><a href="/estimates">Estimates</a></li>
                <li><a href="/invoices">Invoices</a></li>
                <li><a href="/orders/order_transactions/">Orders</a></li>
                <li class="title">Catalogs</li>
                <li><a href="/admin/catalogs/catalogs/dashboard">Dashboard</a></li>
              </ul>
        </li>
        <li> <a href="#"><span>Marketing</span></a>
              <ul>
                <li class="title">Tools</li>
                <li><a href="/admin/notifications/notification_templates">Notifications</a></li>
                <li><a href="/admin/conditions">Conditions</a></li>
                <li><a href="/workflows">Workflows</a></li>
                <li class="title">Reporting</li>
                <li><a href="/admin/reports">Analytics</a></li>
                <li><a href="/admin/reports">Reports</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a href="#"><span>Support</span></a>
              <ul>
                <li class="title">Projects</li>
                <li><a href="/projects">Projects</a></li>
                <li><a href="/timesheets">Timesheets</a></li>
                <li><a href="/tasks/tasks/my">Tasks</a></li>
                <li class="title">Support</li>
                <li><a href="/admin/tickets">Tickets</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a title="Users" href="#"><span>Users</span></a>
              <ul>
                <li class="title">Users</li>
                <li><a href="/users">All Users</a></li>
                <li><a href="/admin/users/user_roles">User Roles</a></li>
                <li class="title">Social</li>
                <li><a href="/users/user_groups">Groups</a></li>
                <li><a href="/users/user_statuses">Statuses</a></li>
                <li><a href="/users/user_walls">Walls</a></li>
                <li><a href="/messages">Messages</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a title="Content" href="/admin/webpages"><span>Extend</span></a>
              <ul>
                <li class="title">App Builder</li>
                <li><a href="/privileges">Privileges</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li><a href="/admin/forms">Custom Forms</a></li>
                <li><a href="/admin/conditions">Conditions</a></li>
                <li><a href="/workflows">Workflows</a></li>
              </ul>
        </li>
      	<li><a href="/users/users/logout/"><span>Logout</span></a></li>
      </ul>
  </div>
</div>