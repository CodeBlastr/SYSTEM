    	<div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="/admin"><span>flo</span>Managr</a>
                    <div class="nav-collapse collapse">
                    
                    	<ul class="nav">
            				<li class="dropdown">
                            	<a href="/admin" class="dropdown-toggle" data-toggle="dropdown">Dashboard <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                	<li><?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index')); ?></li>
                                    <li><?php echo $this->Html->link('Theme', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'theme'), array('escape' => false, 'title' => 'Templates, CSS, Javascript', 'id' => 'navTheme')); ?></li>
                                </ul>
                            </li>
                            <li><?php echo $this->Html->link('Content', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'id' => 'navContent')); ?></li>
                            <li><?php echo $this->Html->link('<span>Contacts</span>', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Leads, Opportunities', 'id' => 'navContacts')); ?></li>
            <li><?php echo $this->Html->link('<span>Ecommerce</span>', array('plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li>
            <li><?php echo $this->Html->link('<span>Billing</span>', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li>
            <li><?php echo $this->Html->link('<span>Support</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets', 'id' => 'navSupport')); ?></li>
            <li><?php echo $this->Html->link('<span>Users</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></li>                            
                        </ul>
                        
                    	<ul class="nav pull-right">
                            <li class="dropdown">
                            	<a href="/users/users/my" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->Session->read('Auth.User.username'); ?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                	<li> 
                                    <form class="navbar-form pull-right">
                                        <input class="span2" type="text" placeholder="Email">
                                        <input class="span2" type="password" placeholder="Password">
                                        <button type="submit" class="btn">Sign in</button>
                                    </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>