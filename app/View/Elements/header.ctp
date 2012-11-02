<?php // $requestUrl = strpos($this->request->url, '/') === 0 ? $this->request->url : '/'.$this->request->url; 
$id = !empty($id) ? $id : 'headerNavFloManagr'; 
$showEditMode = !empty($showEditMode) ? true : false;
$showContext = !empty($showContext) ? true : false; ?>

<div class="navbar navbar-inverse navbar-fixed-top floManagrNav" id="<?php echo $id; ?>">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <ul class="nav">
            	<li class="dropdown">
            		<a class="brand dropdown-toggle" data-toggle="dropdown" href="#"><span>flo</span>Managr <b class="caret"></b></a>
            		<?php echo !empty($showContext) ? $this->Element('context_menu', array('before' => '<li>' . $this->Html->link('View Site', '/') . '</li><li class="divider"></li>')) : null; ?>   
            	</li>
            </ul>
            
            <div class="nav-collapse collapse">
                <ul class="nav">
               		<li><?php echo $this->Html->link('Dashboard', '/admin/', array('title' => 'Admin Dashboard')); ?></li>
               		<?php if (!empty($showEditMode)) { ?><li><a class="dock_btn edit_button" id="edit_button" title="On edit mode"><span>Edit : Off</span></a></li><?php } ?>
                    <li><?php echo $this->Html->link('Content', '/admin/#tagPages+tagMedia+tagDiscussion+tagElements', array('title' => 'Pages, Modules, Media, Categories, Tags, Enumerations', 'onclick' => 'window.location.replace(this.href);window.location.reload(true)')); // takes extra js, because of the hash tags ?></li>
                    <li><?php echo $this->Html->link('Contacts', '/admin/contacts/contacts/dashboard', array('title' => 'Leads, Opportunities')); ?></li>
    				<?php if (in_array('Transactions', CakePlugin::loaded())) { ?><li><?php echo $this->Html->link('Ecommerce', array('plugin' => 'catalogs', 'controller' => 'catalogs', 'action' => 'dashboard'), array('title' => 'Catalogs, Orders', 'id' => 'navProducts')); ?></li><?php } ?>
   					<?php if (in_array('Invoices', CakePlugin::loaded())) { ?><li><?php echo $this->Html->link('Billing', array('plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'dashboard'), array('title' => 'Estimates, Invoices', 'id' => 'navBilling')); ?></li><?php } ?>
    				<?php if (in_array('Projects', CakePlugin::loaded())) { ?><li><?php echo $this->Html->link('Todos', '/admin/#tagProjects', array('title' => 'Projects, Tasks & Timesheets', 'onclick' => 'window.location.replace(this.href);window.location.reload(true)')); ?></li><?php } ?>
    				<li><?php echo $this->Html->link('Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard'), array('title' => 'Social, Groups, Members, Messages', 'id' => 'navUsers')); ?></li>   
      			</ul>
                
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="/users/users/my"><?php echo $this->Session->read('Auth.User.username'); ?></a>
                        <?php /* drop down
                        <a href="/users/users/my" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->Session->read('Auth.User.username'); ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
                            <li> 
                            <form class="navbar-form pull-right">
                                <input class="span2" type="text" placeholder="Email">
                                <input class="span2" type="password" placeholder="Password">
                                <button type="submit" class="btn">Sign in</button>
                            </form>
                            </li>
                        </ul> */ ?>
                    </li>
                    <li>
                        <a href="/users/users/logout" >logout</a>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>