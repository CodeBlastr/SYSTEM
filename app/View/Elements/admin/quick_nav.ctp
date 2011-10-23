<div id="quickNav">
  <div id="quickNavLeft"><?php echo !empty($quickNavBeforeBack_callback) ? $quickNavAfterBack_callback : '' ; ?><a onclick="history.go(-1)" class="back">Back</a><?php echo !empty($quickNavAfterBack_callback) ? $quickNavAfterBack_callback : '' ; ?></div>
  <?php echo $this->Element('page_title'); ?>
  <div id="quickNavRight"> <a href="/admin/" class="menu">Main Menu</a> <a href="/" class="search"><img src="data:image/png;base64,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" /></a> </div>
</div>
<div id="siteSearch" class="hide">
  <form id="searchForm" method="get" action="/admin/searchable/search_indexes/">
    <div class="input">
      <input type="text" value="Search" id="searchInput" name="term" title="Search" class="grayOut toggleTitle">
    </div>
  </form>
</div>
<div id="siteMenu" class="hide">
  <ul>
    <li><?php echo $this->Html->link('<span>Settings</span>', array('plugin' => null, 'controller' => 'admin', 'action' => 'index'), array('escape' => false, 'title' => 'Privileges, Settings, Workflows, Conditions, Custom Forms', 'id' => 'navAdmin')); ?></li>
    <li><?php echo $this->Html->link('<span>Theme</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'theme'), array('escape' => false, 'title' => 'Templates, CSS, Javascript', 'id' => 'navTheme')); ?></li>
    <li><?php echo $this->Html->link('<span>Content</span>', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'id' => 'navContent')); ?></li>
    <li><?php echo $this->Html->link('<span>Contacts</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Leads, Opportunities', 'id' => 'navContacts')); ?></li>
    <li><?php echo $this->Html->link('<span>Products</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li>
    <li><?php echo $this->Html->link('<span>Billing</span>', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li>
    <li><?php echo $this->Html->link('<span>Support</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets', 'id' => 'navSupport')); ?></li>
    <li><?php echo $this->Html->link('<span>Users</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></li>
    <li><?php echo $this->Html->link('<span>Reports</span>', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Report Builder, Analytics', 'id' => 'navReports')); ?></li>
  </ul>
  <?php /*
  <!--ul>
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
  </ul>
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
  </ul--> */ ?>
</div>
