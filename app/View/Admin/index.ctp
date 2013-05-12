<?php
echo $this->Html->script('plugins/jquery.masonry.min', array('inline' => false)); 
/**
 * Admin Dashboard Index View
 *
 * This view is the hub for the admin section of the site. Will be used as the launchpad for site administration.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.views.admin
 * @since         Zuha(tm) v 0.0009
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */ 

if (empty($runUpdates)) { ?>
	
	<?php /* this should only show on dev branch until done
	<div class="row-fluid">
		<ul class="thumbnails">
			<li class="span4">
				<div class="thumbnail">
					<img data-src="holder.js/300x200" alt="300x200" style="width: 360px; height: 200px;" src="data:image/png;base64,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">
					<div class="caption">
						<h3>Thumbnail label</h3>
						<p>
							Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
						</p>
						<p>
							<a href="#" class="btn btn-primary">Action</a><a href="#" class="btn">Action</a>
						</p>
					</div>
				</div>
			</li>
			<li class="span4">
				<div class="thumbnail">
					<img data-src="holder.js/300x200" alt="300x200" style="width: 360px; height: 200px;" src="data:image/png;base64,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">
					<div class="caption">
						<h3>Thumbnail label</h3>
						<p>
							Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
						</p>
						<p>
							<a href="#" class="btn btn-primary">Action</a><a href="#" class="btn">Action</a>
						</p>
					</div>
				</div>
			</li>
			<li class="span4">
				<div class="thumbnail">
					<img data-src="holder.js/300x200" alt="300x200" style="width: 360px; height: 200px;" src="data:image/png;base64,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">
					<div class="caption">
						<h3>Thumbnail label</h3>
						<p>
							Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
						</p>
						<p>
							<a href="#" class="btn btn-primary">Action</a><a href="#" class="btn">Action</a>
						</p>
					</div>
				</div>
			</li>
		</ul>
	</div>
	*/ ?>

    <div class="btn-group">
        <a href="#masonryBox" class="filterClick btn">All</a>
        <?php if (in_array('Products', CakePlugin::loaded())) { ?><a href="/admin/products/products/dashboard" class="btn">Ecommerce</a><?php } ?>
        <a href="#tagPages" class="filterClick btn">Pages</a>
        <a href="#tagMedia" class="filterClick btn">Media</a>
        <?php if (in_array('Comments', CakePlugin::loaded())) { ?><a href="#tagDiscussion" class="filterClick btn">Discussion</a><?php } ?>
        <a href="#tagThemes" class="filterClick btn">Themes</a>
        <a href="#tagAdmin" class="filterClick btn">Settings</a>
    </div>
    
    
    <div class="masonry dashboard">
        <div class="masonryBox dashboardBox tagPages">
            <h3 class="title"><i class="icon-th-large"></i> <?php echo $this->Html->link('Pages', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'content')); ?></h3>
            <p>View, edit, delete, and create static content pages with text, graphics, video and/or audio. </p>
        </div>
        
        <div class="masonryBox dashboardBox tagThemes tagElements">
            <h3 class="title"><i class="icon-th-large"></i> <?php echo $this->Html->link('Widget Elements', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></h3>
            <p>Edit, delete, and create pages and multi-page elements. </p>
            <ul>
                <li><?php echo $this->Html->link('Widget Elements', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></li>
                <li><?php echo $this->Html->link('Menus', array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'index')); ?></li>
            </ul>
        </div>
        
        <?php if (in_array('Media', CakePlugin::loaded())) { ?>
        <div class="masonryBox dashboardBox tagMedia tagThemes">
            <h3 class="title"><i class="icon-th-large"></i> <?php echo $this->Html->link('File Managers', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'content')); ?></h3>
            <p>Edit, delete, and create images, documents, audio and video. </p>
            <ul>
                <li><?php echo $this->Html->link('Media Plugin', array('plugin' => 'media', 'controller' => 'media', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Image Files', array('plugin' => 'media', 'controller' => 'media', 'action' => 'images')); ?></li>
                <li><?php echo $this->Html->link('Document Files', array('plugin' => 'media', 'controller' => 'media', 'action' => 'files')); ?></li>
            </ul>
        </div>
        <?php } ?> 
        
        <div class="masonryBox dashboardBox tagThemes">
            <h3 class="title"><i class="icon-file"></i> <?php echo $this->Html->link('Appearance', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'template')); ?></h3>
            <p>Manage the look and feel of your site.</p>
            <ul>
                <li><?php echo $this->Html->link('Templates', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'template')); ?></li>
                <li><?php echo $this->Html->link('Menus', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Widget Elements', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></li>
                <li><?php echo $this->Html->link('Css Styles', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpage_csses', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Javascript', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpage_jses', 'action' => 'index')); ?></li>
                <?php if (in_array('Media', CakePlugin::loaded())) { ?>
                <li><?php echo $this->Html->link('Image Files', array('admin' => true, 'plugin' => 'media', 'controller' => 'media', 'action' => 'images')); ?></li>
                <li><?php echo $this->Html->link('Document Files', array('admin' => true, 'plugin' => 'media', 'controller' => 'media', 'action' => 'files')); ?></li>
                <?php } ?>
            </ul>
        </div>
		
		<?php if (in_array('Blogs', CakePlugin::loaded())) { ?>
        <div class="masonryBox dashboardBox tagBlogs tagPages">
            <h3 class="title"><i class="icon-file"></i> <?php echo $this->Html->link('Blogs', array('admin' => true, 'plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index')); ?></h3>
            <p>Create multiple blogs, and post new content.</p>
            <ul>
            	<?php
            	if (!empty($blogs)) {
            		foreach ($blogs as $blog) {
            			echo __('<li>%s to %s</li>', $this->Html->link('Add Post', array('admin' => true, 'plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'add', $blog['Blog']['id'])), $this->Html->link($blog['Blog']['title'], array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'view', $blog['Blog']['id'])));
            		}
            	} ?>
            </ul>
        </div>
        <?php } ?>
		
		<?php if (in_array('Comments', CakePlugin::loaded())) { ?>
        <div class="masonryBox dashboardBox tagComments tagDiscussion">
            <h3 class="title"><i class="icon-comment"></i> <?php echo $this->Html->link('Comments', array('admin' => true, 'plugin' => 'comments', 'controller' => 'comments', 'action' => 'index')); ?></h3>
            <p>See and manage the discussions going on.</p>
        </div>
        <?php } ?>
		
		<?php if (in_array('Galleries', CakePlugin::loaded())) { ?>        
        <div class="masonryBox dashboardBox tagGalleries tagMedia">
            <h3 class="title"><i class="icon-picture"></i> <?php echo $this->Html->link('Galleries', array('admin' => true, 'plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'dashboard', 'admin' => 'true')); ?></h3>
            <p>Add and edit image and video galleries</p>
        </div>
        <?php } ?>
		      
        <div class="masonryBox dashboardBox tagMedia">
            <h3 class="title"><i class="icon-picture"></i> Favicon</h3>
            <p>Add the little icon that appears in browser title bars. </p>
          	<?php
          	echo $this->Form->create('Admin', array('type' => 'file'));
			echo $this->Form->input('icon', array('type' => 'file', 'label' => false));
			echo $this->Form->end('Upload'); ?>
        </div>
		
		<?php if (in_array('Categories', CakePlugin::loaded())) { ?>  
        <div class="masonryBox dashboardBox tagText tagAdmin">
            <h3 class="title"><i class="icon-tasks"></i> <?php echo $this->Html->link('Categories', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'index')); ?></h3>
            <p>Categorize anything.  Move, reorder, add, edit categories.</p>
        </div>
        <?php } ?>
		
		<?php if (in_array('Tags', CakePlugin::loaded())) { ?>          
        <div class="masonryBox dashboardBox tagTags tagAdmin">
            <h3 class="title"><i class="icon-tags"></i> <?php echo $this->Html->link('Tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')); ?></h3>
            <p>Tag anything.  Move, reorder, add, edit tags.</p>
        </div>
        <?php } ?>
        
        <div class="masonryBox dashboardBox tagPrivileges tagAdmin">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'index')); ?></h3>
            <p>Control what content your different user roles can see.</p>
        </div>
         
        <div class="masonryBox dashboardBox tagSettings tagAdmin">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Settings', array('plugin' => null, 'controller' => 'settings', 'action' => 'index')); ?></h3>
            <p>Configure your system with customizable variables.</p>
        </div>
        
		<?php if (in_array('Forms', CakePlugin::loaded())) { ?>  
        <div class="masonryBox dashboardBox tagForms tagPages">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Custom Forms', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index')); ?></h3>
            <p>Create custom forms, so users can interact with your site how you want them to..</p>
        </div>
        <?php } ?>
        
        <div class="masonryBox dashboardBox tagConditions tagAdmin">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Conditions', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')); ?></h3>
            <p>Create customized actions for use in workflows.</p>
        </div>
        
		<?php if (in_array('Workflows', CakePlugin::loaded())) { ?>  
        <div class="masonryBox dashboardBox tagWorkflows tagAdmin">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Workflows', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index')); ?></h3>
            <p>Automate what happens after a condition is met.</p>
        </div>
        <?php } ?>
        
        <div class="masonryBox dashboardBox tagAdmin">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Enumerations', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index')); ?></h3>
            <p>Manage the labels that appear in system drop downs.</p>
        </div>
        
        <div class="masonryBox dashboardBox tagUpdates tagAdmin">
            <h3 class="title"><i class="icon-globe"></i> Install Updates </h3>
            <p>Check for updates, install plugins, and  generally improve your site system.
            <p><?php echo $this->Html->link('Install Plugins', array('plugin' => null, 'controller' => 'install', 'action' => 'index')); ?></p>
			<p><?php echo $this->Form->create('', array('id' => 'updateForm')); echo $this->Form->hidden('Upgrade.all', array('value' => true)); echo $this->Form->submit('Check for Updates'); echo $this->Form->end(); ?></p>
        </div>
        
        <?php if (in_array('Projects', CakePlugin::loaded())) { ?>
        <div class="masonryBox dashboardBox tagProjects tagTimesheets">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Projects', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index')); ?> </h3>
            <p>Setup projects, with messages, tasks, people and track time.</p>
            <ul>
                <li><?php echo $this->Html->link('Timesheets', array('plugin' => 'timesheets', 'controller' => 'timesheets', 'action' => 'index')); ?></li>
            </ul>
        </div>
        <?php } ?>
        
        <?php if (in_array('Tasks', CakePlugin::loaded())) { ?>
        <div class="masonryBox dashboardBox tagProjects tagTasks">
            <h3 class="title"><i class="icon-globe"></i> <?php echo $this->Html->link('Tasks', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'my')); ?> </h3>
            <p>See and manage all to-do tasks whether they're for a project a contact or anything else.</p>
        </div>
        <?php } ?>
		
    </div>
<?php
} else { ?>

  <div id="databaseUpgrades">
      <?php 
       $complete = CakeSession::read('Updates.complete');
       echo $this->Form->create('', array('id' => 'autoUpdateForm')); 
       echo $this->Form->hidden('Upgrade.all', array('value' => true));
       //echo $this->Form->submit('Check for Updates');
       echo $this->Form->end(); ?>
    <ul>
      <?php
    if (CakeSession::read('Updates.last')) {
      foreach (CakeSession::read('Updates.last') as $table => $action) {
        echo __('<li>Table %s is %s</li>', $table, $action);
      }
    }?>
    </ul>
  </div>

  <?php
    $complete = CakeSession::read('Updates.complete');
    if (CakeSession::read('Updates') && empty($complete)) {  ?>
    <script type="text/javascript">
        $(function() {
            //var pathname = window.location.pathname;
            //window.location.replace(pathname);
           // alert('lets refresh');
       $("#autoUpdateForm").submit();
        });
        </script>
<?php 
    } 
} ?>
