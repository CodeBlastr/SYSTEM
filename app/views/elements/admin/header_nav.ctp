<div id="header">
  <div class="middleContent">
    <!-- secure -->
    <div id="globalNav">
      <ul>
        <li class="first"><a title="Business Management System" href="/admin"></a></li>
        <li> <a href="#"><span>Design</span></a>
          <div class="sub">
            <div class="menu">
              <ul>
                <li class="title">Design</li>
                <li><?php echo $this->Html->link('Templates', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'template')); ?></li>
                <li><a href="/webpages/webpages/index/type:element/">Elements</a></li>
                <li><a href="/webpages/webpage_csses">Css Files</a></li>
                <li class="separator"><a href="/webpages/webpage_jses">Js Files</a></li>
              </ul>
              <ul>
                <li class="title">Files</li>
                <li><a href="/admin/admin/files_image">Images</a></li>
                <li class="separator"><a href="/admin/admin/files_files">Documents</a></li>
              </ul>
              <p class="other"><a href="#" title="Design Dashboard">Dashboard</a></p>
            </div>
          </div>
        </li>
        <li> <a href="#"><span>Content</span></a>
          <div class="sub">
            <div class="menu">
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
                <li ><a href="/admin/faqs">Faqs</a></li>
                <li ><a href="/admin/forum/forum_home">Forums</a></li>
                <li ><a href="/admin/maps">Maps</a></li>
                <li><a href="/admin/galleries">Galleries</a></li>
                <li class="separator"><a href="/admin/wikis">Wikis</a></li>
              </ul>
              <ul>
                <li class="title">Labels</li>
                <li><a href="/admin/categories">Categories</a></li>
                <li><a href="/admin/tags">Tags</a></li>
                <li class="separator"><a href="/admin/enumerations">Enumerations</a></li>
              </ul>
              <p class="other"><a href="#" title="Content Dashboard">Dashboard</a></p>
            </div>
          </div>
        </li>
        <li class="endColumn"> <a href="#"><span>Sales</span></a>
          <div class="sub">
            <div class="menu">
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
                <li class="title">Products</li>
                <li class="separator"><a href="/catalogs/catalog_items">Products</a></li>
              </ul>
              <p class="other"><a href="#" title="Sales Dashboard">Dashboard</a></p>
            </div>
          </div>
        </li>
        <li> <a href="/admin/reports/reports/dashboard"><span>Marketing</span></a>
          <div class="sub">
            <div class="menu">
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
              <p class="other"><a href="/admin/reports/reports/dashboard" title="Marketing Dashboard">Dashboard</a></p>
            </div>
          </div>
        </li>
        <li class="endColumn"> <a href="#"><span>Support</span></a>
          <div class="sub">
            <div class="menu">
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
              <p class="other"><a href="#" title="Support Dashboard">Dashboard</a></p>
            </div>
          </div>
        </li>
        <li class="endColumn"> <a href="#" title="Users"><span>Users</span></a>
          <div class="sub">
            <div class="menu">
              <ul>
                <li class="title">Users</li>
                <li><a href="/users">All Users</a></li>
                <li class="separator"><?php echo $this->Html->link('User Roles', array('plugin' => 'users', 'controller' => 'user_roles', 'action' => 'index')); ?></li>
              </ul>
              <ul>
                <li class="title">Social</li>
                <li><a href="/users/user_groups">Groups</a></li>
                <li><a href="/users/user_statuses">Statuses</a></li>
                <li><a href="/users/user_walls">Walls</a></li>
                <li class="separator"><a href="/messages">Messages</a></li>
              </ul>
              <p class="other"><a href="#" title="Users Dashboard">Dashboard</a></p>
            </div>
          </div>
        </li>
        <li class="endColumn"> <a href="/admin/webpages" title="Content"><span>Extend</span></a>
          <div class="sub">
            <div class="menu">
              <ul>
                <li class="title">App Builder</li>
                <li><a href="/privileges">Privileges</a></li>
                <li><a href="/admin/settings">Settings</a></li>
                <li><a href="/admin/forms">Custom Forms</a></li>
                <li><a href="/admin/conditions">Conditions</a></li>
                <li class="separator"><a href="/workflows">Workflows</a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="searchfield">
      <form id="searchForm" method="get" action="/admin/searchable/search_indexes/">
        <div class="input">
          <input type="text" value="Search" id="searchInput" name="term" title="Search" class="grayOut toggleTitle"/>
        </div>
      </form>
    </div>
  </div>
</div>
