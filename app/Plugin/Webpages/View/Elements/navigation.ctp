<?php $requestUrl = strpos($this->request->url, '/') === 0 ? $this->request->url : '/'.$this->request->url; ?>

<div id="slidedock">
  <div id="slidedock_content">
    <ul>
      <li><a class="dock_btn edit_button" id="edit_button" title="On edit mode"><span>Edit Mode : Off</span></a></li>
      <li><a href="<?php echo '/'.$this->Session->read('Auth.User.view_prefix').$requestUrl; ?>"><span><?php echo $this->Session->read('Auth.User.view_prefix'); ?> This Page</span></a>
      <?php echo $this->Element('context_menu'); ?>
      </li>
      <li><?php echo $this->Html->link('<span>Dashboard</span>', array('plugin' => null, 'controller' => 'admin', 'action' => 'index'), array('escape' => false, 'title' => 'Privileges, Settings, Workflows, Conditions, Custom Forms', 'id' => 'navAdmin')); ?>
        <ul>
          <li><?php echo $this->Html->link('<span>Privileges</span>', array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index'), array('escape' => false, 'title' => 'Manage user role access to sections.')); ?></li>
          <li><?php echo $this->Html->link('<span>Settings</span>', array('plugin' => null, 'controller' => 'settings', 'action' => 'index'), array('escape' => false, 'title' => 'Set your custom configuration options.')); ?></li>
          <li><?php echo $this->Html->link('<span>Forms</span>', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index'), array('escape' => false, 'title' => 'Customize forms and manage database fields.')); ?></li>
          <li><?php echo $this->Html->link('<span>Conditions</span>', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index'), array('escape' => false, 'title' => 'Advanced website automation by matching conditions to future actions.')); ?></li>
          <li><?php echo $this->Html->link('<span>Workflows</span>', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index'), array('escape' => false, 'title' => 'The actions your conditions will force to happen.')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span>Theme</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'theme'), array('escape' => false, 'title' => 'Templates, CSS, Javascript, File Manager')); ?>
      
        <ul>
          <li><?php echo $this->Html->link('<span>Templates</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'template'), array('escape' => false, 'title' => 'Manage the html wrapping that goes around your content.')); ?></li>
          <li><?php echo $this->Html->link('<span>Global Boxes</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'element'), array('escape' => false, 'title' => 'Manage small snippets that are used on multiple pages.')); ?></li>
          <li class="title">Files</li>
          <li><?php echo $this->Html->link('<span>Css Files</span>', array('plugin' => 'webpages', 'controller' => 'webpage_csses', 'action' => 'index'), array('escape' => false, 'title' => 'Add and edit css files to style your pages.')); ?></li>
          <li><?php echo $this->Html->link('<span>Js Files</span>', array('plugin' => 'webpages', 'controller' => 'webpage_jses', 'action' => 'index'), array('escape' => false, 'title' => 'Add and edit javascript files to add extra user interface features to your pages.')); ?></li>
          <li><?php echo $this->Html->link('<span>Image Files</span>', array('plugin' => 'media', 'controller' => 'media', 'action' => 'images'), array('escape' => false, 'title' => 'Upload and manage images on your site.')); ?></li>
          <li><?php echo $this->Html->link('<span>Documents</span>', array('plugin' => 'media', 'controller' => 'media', 'action' => 'files'), array('escape' => false, 'title' => 'Upload and manage documents for your site.')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span>Content</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Pages, Blogs, Wikis, and more...')); ?>
        <ul>
          <li><?php echo $this->Html->link('<span>Pages</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index'), array('escape' => false, 'title' => 'Add and edit content type pages.')); ?></li>
          <li class="title">Feedback</li>
          <li><?php echo $this->Html->link('<span>Comments</span>', array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'index'), array('escape' => false, 'title' => 'Manage user feedback.')); ?></li>
          <li><?php echo $this->Html->link('<span>Ratings</span>', array('plugin' => 'ratings', 'controller' => 'ratings', 'action' => 'index'), array('escape' => false, 'title' => 'Manage rankings of different content sections.')); ?></li>
          <li><?php echo $this->Html->link('<span>Invites</span>', array('plugin' => 'invite', 'controller' => 'invites', 'action' => 'invitation'), array('escape' => false, 'title' => 'Let your users invite other users to your pages.')); ?></li>
          <li class="title">Labels</li>
          <li><?php echo $this->Html->link('<span>Categories</span>', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'tree'), array('escape' => false, 'title' => 'Put anything into categories.')); ?></li>
          <li><?php echo $this->Html->link('<span>Tags</span>', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index'), array('escape' => false, 'title' => 'Tag anything for easy search when you want to find it.')); ?></li>
          <li><?php echo $this->Html->link('<span>Enumerations</span>', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index'), array('escape' => false, 'title' => 'Manage the different "types" your plugins support.')); ?></li>
          <li class="title">Extras</li>
          <li><?php echo $this->Html->link('<span>Blogs</span>', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index'), array('escape' => false, 'title' => 'Create new content quickly, with your own blog.')); ?></li>
          <li><?php echo $this->Html->link('<span>Faqs</span>', array('plugin' => 'faqs', 'controller' => 'faqs', 'action' => 'index'), array('escape' => false, 'title' => 'Support your users by providing answers to frequently asked questions.')); ?></li>
          <li><?php echo $this->Html->link('<span>Maps</span>', array('plugin' => 'maps', 'controller' => 'maps', 'action' => 'index'), array('escape' => false, 'title' => 'Plot locations on a map and show your users geographic locations they should be interested in.')); ?></li>
          <li><?php echo $this->Html->link('<span>Galleries</span>', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Manage groups of images in viewable galleries.')); ?></li>
          <li><?php echo $this->Html->link('<span>Wikis</span>', array('plugin' => 'wikis', 'controller' => 'wikis', 'action' => 'index'), array('escape' => false, 'title' => 'Create content, and let your users add to and edit that content.')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span>Contacts</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Manage Contacts, Leads &amp; Activities')); ?>
      	<ul>
          <li><?php echo $this->Html->link('<span>Companies</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'index'), array('escape' => false, 'title' => 'List all companies.')); ?></li>
          <li><?php echo $this->Html->link('<span>People</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'people'), array('escape' => false, 'title' => 'List all people.')); ?></li>
          <li><?php echo $this->Html->link('<span>Leads</span>', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'my'), array('escape' => false, 'title' => 'Manage who you need to follow up with with contact tasks.')); ?></li>
          <li><?php echo $this->Html->link('<span>Activities</span>', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index'), array('escape' => false, 'title' => 'Track the activity made for leads so that its easy to refer to later.')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span>Ecommerce</span>', array('plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders')); ?>
      	<ul>
          <li><?php echo $this->Html->link('<span>Catalog Items</span>', array('plugin' => 'catalogs', 'controller' => 'catalog_items', 'action' => 'index'), array('escape' => false, 'title' => 'Add, edit, view, delete catalog items.')); ?></li>
          <li><?php echo $this->Html->link('<span>Orders</span>', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index'), array('escape' => false, 'title' => 'Manage &amp; track sales, and fulfill orders.')); ?></li>
        </ul>      
      </li>
      <li><?php echo $this->Html->link('<span>Billing</span>', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices')); ?>
      	<ul>
          <li><?php echo $this->Html->link('<span>Invoices</span>', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'index'), array('escape' => false, 'title' => 'Manage invoices and billing.')); ?></li>
          <li><?php echo $this->Html->link('<span>Estimates</span>', array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'index'), array('escape' => false, 'title' => 'Create estimates for your clients.')); ?></li>
        </ul>     
      </li>
      <li><?php echo $this->Html->link('<span>Support</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets')); ?>
      	<ul>
          <li><?php echo $this->Html->link('<span>Projects</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index'), array('escape' => false, 'title' => 'Create and manage projects.')); ?></li>
          <li><?php echo $this->Html->link('<span>Timesheets</span>', array('plugin' => 'timesheets', 'controller' => 'timesheets', 'action' => 'index'), array('escape' => false, 'title' => 'Track time to your project tasks.')); ?></li>
          <li><?php echo $this->Html->link('<span>Tasks</span>', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'my'), array('escape' => false, 'title' => 'View and manage your upcoming tasks.')); ?></li>
          <li><?php echo $this->Html->link('<span>Tickets</span>', array('plugin' => 'tickets', 'controller' => 'tickets', 'action' => 'index'), array('escape' => false, 'title' => 'Manage your custom support departments and issues.')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span>Users</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Social, Groups, Members, Messages')); ?>
      	<ul>
          <li><?php echo $this->Html->link('<span>All Users</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'), array('escape' => false, 'title' => 'View a list of all registered users.')); ?></li>
          <li><?php echo $this->Html->link('<span>User Roles</span>', array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'index'), array('escape' => false, 'title' => 'Manage the roles that users can have to control site access.')); ?></li>
          <li class="title">Social</li>
          <li><?php echo $this->Html->link('<span>Groups</span>', array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'index'), array('escape' => false, 'title' => 'Groups for putting associating users together.')); ?></li>
          <li><?php echo $this->Html->link('<span>Statuses</span>', array('plugin' => 'users', 'controller' => 'user_statuses', 'action' => 'index'), array('escape' => false, 'title' => 'Whats going on? Let your users tell everyone.')); ?></li>
          <li><?php echo $this->Html->link('<span>Walls</span>', array('plugin' => 'users', 'controller' => 'user_walls', 'action' => 'index'), array('escape' => false, 'title' => 'Its not a blog, its not a status, its a wall.')); ?></li>
          <li><?php echo $this->Html->link('<span>Messages</span>', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index'), array('escape' => false, 'title' => 'Communication between registered users, and beyond.')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span>Reports</span>', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Site traffic analysis, and create custom reports.')); ?>
      	<ul>
          <li><?php echo $this->Html->link('<span>Analytics</span>', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Analyze your website trafic.')); ?></li>
          <li><?php echo $this->Html->link('<span>Reports</span>', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'index'), array('escape' => false, 'title' => 'View and create reports.')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span>Logout</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'), array('escape' => false, 'title' => 'View and create reports.')); ?></li>
    </ul>
  </div>
</div>
