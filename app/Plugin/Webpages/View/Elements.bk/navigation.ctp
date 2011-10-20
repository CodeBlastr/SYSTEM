<!--div id="slidedock">
  <div id="slidedock_content">
    <ul>
      <li><a class="dock_btn edit_button" id="edit_button" title="On edit mode"><span>Edit Mode : Off</span></a></li>
      <li><a href="<?php echo '/'.$this->Session->read('Auth.User.view_prefix').'/'.$this->request->url; ?>"><span><?php echo $this->Session->read('Auth.User.view_prefix'); ?></span></a></li>
      <li class="title"><a href="/webpages/webpages/index/type:template" title="Edit Template"><span>CMS</span></a>
        <ul>
          <li><a href="/webpages/webpages/index/type:page_content/">Webpages</a></li>
          <li><?php echo $this->Html->link('Templates', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'template')); ?></li>
          <li><a href="/webpages/webpages/index/type:element/">Elements</a></li>
          <li><a href="/webpages/webpage_csses">Css</a></li>
          <li class="separator"><a href="/webpages/webpage_jses">Javscript</a></li>
          <li class="title">File Manager</li>
          <li><a href="/admin/admin/files_image">Images</a></li>
          <li class="separator"><a href="/admin/admin/files_files">Documents</a></li>
          <?php if (!empty($defaultTemplate['Menu'])) : foreach ($defaultTemplate['Menu'] as $menu) : ?>
          <li><a class="dialog" href="/menus/menu_items/add/<?php echo $menu['id']; ?>/<?php echo !empty($title_for_layout) ? urlencode($title_for_layout) : Inflector::humanize($this->request->params['action'].' '.$this->request->params['controller']); ?>/<?php echo base64_encode($_SERVER['REQUEST_URI']); ?>" title="Add to Menu"><span>Add to <?php echo $menu['name']; ?></span></a></li>
          <?php endforeach; endif; ?>
          
          
          <li class="title">Extended</li>
          <li><a href="/blogs">Blogs</a></li>
          <li><a href="/admin/comments">Comments</a></li>
          <li ><a href="/admin/faqs">Faqs</a></li>
          <li><a href="/admin/forms">Forms</a></li>
          <li ><a href="/admin/forum/forum_home">Forums</a></li>
          <li ><a href="/admin/maps">Maps</a></li>
          <li><a href="/admin/galleries">Galleries</a></li>
          <li class="separator"><a href="/admin/wikis">Wikis</a></li>
          <li class="title">Labels</li>
          <li><a href="/admin/categories">Categories</a></li>
          <li><a href="/admin/tags">Tags</a></li>
          <li class="separator"><a href="/admin/enumerations">Enumerations</a></li>
          <li>Ratings (coming soon)</li>
          <li class="separator">
            <a href="/invite/invites/invitation">
            Invites (coming soon)</li>
        </ul>
      </li>
      <?php /*foreach ($editorUserRoles as $role) : ?>
		    	<li><a href="/users/user_roles/display_role/<?php echo $role; ?>"><span>View as <?php echo Inflector::singularize($role); ?></span></a></li>
			    <?php endforeach; */?>
      <li><a href="/users/users/logout/"><span>Logout</span></a></li>
    </ul>
    
    
    
    
    
  </div>
</div-->


<div id="slidedock">
  <div id="slidedock_content">
      <ul>
      	<li><a class="dock_btn edit_button" id="edit_button" title="On edit mode"><span>Edit Mode : Off</span></a></li>
	    <li><a href="<?php echo '/'.$this->Session->read('Auth.User.view_prefix').'/'.$this->request->url; ?>"><span><?php echo $this->Session->read('Auth.User.view_prefix'); ?></span></a></li>
        <li> <a href="#"><span>Design</span></a>
          <ul>
                <li class="title">Design</li>
                <li><a href="/admin/webpages/webpages/index/type:template">Templates</a></li>
                <li><a href="/webpages/webpages/index/type:element/">Elements</a></li>
                <li><a href="/webpages/webpage_csses">Css Files</a></li>
                <li class="separator"><a href="/webpages/webpage_jses">Js Files</a></li>
              </ul>
              <ul>
                <li class="title">Files</li>
                <li><a href="/admin/admin/files_image">Images</a></li>
                <li class="separator"><a href="/admin/admin/files_files">Documents</a></li>
              </ul>
        </li>
        <li> <a href="#"><span>Content</span></a>
              <ul>
                <li class="title">Content</li>
                <li><a href="/webpages/webpages/index/type:page_content/">Webpages</a></li>
                <li><a href="/admin/admin/files_image">Images</a></li>
                <li class="separator"><a href="/admin/admin/files_files">Documents</a></li>
                <li class="separator"><a href="/admin/forms">Custom Forms</a></li>
              </ul>
              <ul>
                <li class="title">Feedback</li>
                <li><a href="/admin/comments">Comments</a></li>
                <li>Ratings (coming soon)</li>
                <li class="separator"><!--a href="/invite/invites/invitation"-->Invites (coming soon)</li>
              </ul>
              <ul>
                <li class="title">Extended</li>
                <li><a href="/blogs">Blogs</a></li>
                <li><a href="/admin/faqs">Faqs</a></li>
                <li><a href="/admin/forum/forum_home">Forums</a></li>
                <li><a href="/admin/maps">Maps</a></li>
                <li><a href="/admin/galleries">Galleries</a></li>
                <li class="separator"><a href="/admin/wikis">Wikis</a></li>
              </ul>
              <ul>
                <li class="title">Labels</li>
                <li><a href="/admin/categories">Categories</a></li>
                <li><a href="/admin/tags">Tags</a></li>
                <li class="separator"><a href="/admin/enumerations">Enumerations</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a href="#"><span>Sales</span></a>
              <ul>
                <li class="title">Contacts</li>
                <li><a href="/contacts">All Contacts</a></li>
                <li><a href="/contacts/contact_people">People</a></li>
                <li class="separator"><a href="/contacts/contact_companies">Companies</a></li>
              </ul>
              <ul>
                <li class="title">Tracking</li>
                <li><!--a href="/contacts/contacts/tasks"-->Leads (coming soon)</li>
                <li class="separator"><!--a href="/contacts/contacts/messages/"-->Activities (coming soon)</li>
              </ul>
              <ul>
                <li class="title">Sales</li>
                <li><a href="/estimates">Estimates</a></li>
                <li><a href="/invoices">Invoices</a></li>
                <li class="separator"><a href="/orders/order_transactions/">Orders</a></li>
              </ul>
              <ul>
                <li class="title">Catalogs</li>
                <li class="separator"><a href="/admin/catalogs/catalogs/dashboard">Dashboard</a></li>
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
        <li class="endColumn"> <a title="Users" href="#"><span>Users</span></a>
              <ul>
                <li class="title">Users</li>
                <li><a href="/users">All Users</a></li>
                <li class="separator"><a href="/admin/users/user_roles">User Roles</a></li>
              </ul>
              <ul>
                <li class="title">Social</li>
                <li><a href="/users/user_groups">Groups</a></li>
                <li><a href="/users/user_statuses">Statuses</a></li>
                <li><a href="/users/user_walls">Walls</a></li>
                <li class="separator"><a href="/messages">Messages</a></li>
              </ul>
        </li>
        <li class="endColumn"> <a title="Content" href="/admin/webpages"><span>Extend</span></a>
              <ul>
                <li class="title">App Builder</li>
                <li><a href="/privileges">Privileges</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li><a href="/admin/forms">Custom Forms</a></li>
                <li><a href="/admin/conditions">Conditions</a></li>
                <li class="separator"><a href="/workflows">Workflows</a></li>
              </ul>
        </li>
      	<li><a href="/users/users/logout/"><span>Logout</span></a></li>
      </ul>
  </div>
</div>