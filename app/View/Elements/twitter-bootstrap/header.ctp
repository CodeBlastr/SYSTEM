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
                            <li><?php echo $this->Html->link('Content', '/admin/#tagPages+tagMedia+tagDiscussion', array('escape' => false, 'title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'onclick' => 'window.location.replace(this.href);window.location.reload(true)')); // takes extra js, because of the hash tags ?></li>
                            <li><?php echo $this->Html->link('Contacts', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Leads, Opportunities', 'id' => 'navContacts')); ?></li>
            <li><?php echo $this->Html->link('<span>Ecommerce</span>', array('plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li>
            <li><?php echo $this->Html->link('<span>Billing</span>', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li>
            <li><?php echo $this->Html->link('<span>Todos</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets', 'id' => 'navSupport')); ?></li>
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