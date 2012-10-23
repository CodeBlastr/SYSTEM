<?php // $requestUrl = strpos($this->request->url, '/') === 0 ? $this->request->url : '/'.$this->request->url; ?>
<?php
$id = !empty($id) ? $id : 'headerNavFloManagr'; 
$showEditMode = !empty($showEditMode) ? true : false;
$showContext = !empty($showContext) ? true : false; ?>

<div class="navbar navbar-inverse navbar-fixed-top" id="<?php echo $id; ?>">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo '/'.$this->Session->read('Auth.User.view_prefix'); ?>"><span>flo</span>Managr</a>
            <div class="nav-collapse collapse">
            
                <ul class="nav">
               		<li><a class="dock_btn edit_button" id="edit_button" title="On edit mode"><span>Edit : Off</span></a></li>
                    <li><?php echo $this->Html->link('Content', '/admin/#tagPages+tagMedia+tagDiscussion+tagElements', array('escape' => false, 'title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'onclick' => 'window.location.replace(this.href);window.location.reload(true)')); // takes extra js, because of the hash tags ?></li>
                    <li><?php echo $this->Html->link('Contacts', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Leads, Opportunities', 'id' => 'navContacts')); ?></li>
    				<li><?php echo $this->Html->link('Ecommerce', array('plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li>
   					<?php if (in_array('Invoices', CakePlugin::loaded())) { ?><li><?php echo $this->Html->link('Billing', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li><?php } ?>
    				<li><?php echo $this->Html->link('Todos', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Projects, Tickets, Timesheets', 'id' => 'navSupport')); ?></li>
    				<li><?php echo $this->Html->link('Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></li>   
      				<?php echo $this->Element('context_menu'); ?>                         
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