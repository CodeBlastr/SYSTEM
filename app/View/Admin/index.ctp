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
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.views.admin
 * @since         Zuha(tm) v 0.0009
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
 
if (empty($runUpdates)) { ?>
    
    <div class="btn-group">
        <a href="#masonryBox" class="filterClick btn">All</a>
        <a href="#tagPages" class="filterClick btn">Pages</a>
        <a href="#tagMedia" class="filterClick btn">Media</a>
        <?php if (in_array('Comments', CakePlugin::loaded())) { ?><a href="#tagDiscussion" class="filterClick btn">Discussion</a><?php } ?>
        <a href="#tagThemes" class="filterClick btn">Themes</a>
        <a href="#tagAdmin" class="filterClick btn">Settings</a>
    </div>
    
    
    <div class="masonry">
        <div class="masonryBox tagPages">
            <h3><i class="icon-th-large"></i> <?php echo $this->Html->link('Pages', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'page_content')); ?></h3>
            <p>View, edit, delete, and create static content pages with text, graphics, video and/or audio. </p>
        </div>
        
        <div class="masonryBox tagThemes tagElements">
            <h3><i class="icon-th-large"></i> <?php echo $this->Html->link('Widget Elements', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></h3>
            <p>Edit, delete, and create pages and multi-page elements. </p>
            <ul>
                <li><?php echo $this->Html->link('Widget Elements', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></li>
                <li><?php echo $this->Html->link('Menus', array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'index')); ?></li>
            </ul>
        </div>
        
        <?php if (in_array('Media', CakePlugin::loaded())) { ?>
        <div class="masonryBox tagMedia tagThemes">
            <h3><i class="icon-th-large"></i> <?php echo $this->Html->link('File Managers', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'page_content')); ?></h3>
            <p>Edit, delete, and create images, documents, audio and video. </p>
            <ul>
                <li><?php echo $this->Html->link('Media Plugin', array('plugin' => 'media', 'controller' => 'media', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Image Files', array('plugin' => 'media', 'controller' => 'media', 'action' => 'images')); ?></li>
                <li><?php echo $this->Html->link('Document Files', array('plugin' => 'media', 'controller' => 'media', 'action' => 'files')); ?></li>
            </ul>
        </div>
        <?php } ?> 
        
        <div class="masonryBox tagThemes">
            <h3><i class="icon-file"></i> <?php echo $this->Html->link('Appearance', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'template')); ?></h3>
            <p>Manage the look and feel of your site.</p>
            <ul>
                <li><?php echo $this->Html->link('Templates', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'template')); ?></li>
                <li><?php echo $this->Html->link('Menus', array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Widget Elements', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></li>
                <li><?php echo $this->Html->link('Css Styles', array('plugin' => 'webpages', 'controller' => 'webpage_csses', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Javascript', array('plugin' => 'webpages', 'controller' => 'webpage_jses', 'action' => 'index')); ?></li>
                <?php if (in_array('Media', CakePlugin::loaded())) { ?>
                <li><?php echo $this->Html->link('Image Files', array('plugin' => 'media', 'controller' => 'media', 'action' => 'images')); ?></li>
                <li><?php echo $this->Html->link('Document Files', array('plugin' => 'media', 'controller' => 'media', 'action' => 'files')); ?></li>
                <?php } ?>
            </ul>
        </div>
		
		<?php if (in_array('Blogs', CakePlugin::loaded())) { ?>
        <div class="masonryBox tagBlogs tagPages">
            <h3><i class="icon-file"></i> <?php echo $this->Html->link('Blogs', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index')); ?></h3>
            <p>Create multiple blogs, and post new content.</p>
        </div>
        <?php } ?>
		
		<?php if (in_array('Comments', CakePlugin::loaded())) { ?>
        <div class="masonryBox tagComments tagDiscussion">
            <h3><i class="icon-comment"></i> <?php echo $this->Html->link('Comments', array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'index')); ?></h3>
            <p>See and manage the discussions going on.</p>
        </div>
        <?php } ?>
		
		<?php if (in_array('Galleries', CakePlugin::loaded())) { ?>        
        <div class="masonryBox tagGalleries tagMedia">
            <h3><i class="icon-picture"></i> <?php echo $this->Html->link('Galleries', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index')); ?></h3>
            <p>Add and edit image and video galleries</p>
        </div>
        <?php } ?>
		
		<?php if (in_array('Categories', CakePlugin::loaded())) { ?>  
        <div class="masonryBox tagText tagAdmin">
            <h3><i class="icon-tasks"></i> <?php echo $this->Html->link('Categories', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'index')); ?></h3>
            <p>Categorize anything.  Move, reorder, add, edit categories.</p>
        </div>
        <?php } ?>
		
		<?php if (in_array('Tags', CakePlugin::loaded())) { ?>          
        <div class="masonryBox tagTags tagAdmin">
            <h3><i class="icon-tags"></i> <?php echo $this->Html->link('Tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')); ?></h3>
            <p>Tag anything.  Move, reorder, add, edit tags.</p>
        </div>
        <?php } ?>
        
        <div class="masonryBox tagPrivileges tagAdmin">
            <h3><i class="icon-globe"></i> <?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'index')); ?></h3>
            <p>Control what content your different user roles can see.</p>
        </div>
         
        <div class="masonryBox tagSettings tagAdmin">
            <h3><i class="icon-globe"></i> <?php echo $this->Html->link('Settings', array('plugin' => null, 'controller' => 'settings', 'action' => 'index')); ?></h3>
            <p>Configure your system with customizable variables.</p>
        </div>
        
		<?php if (in_array('Forms', CakePlugin::loaded())) { ?>  
        <div class="masonryBox tagForms tagPages">
            <h3><i class="icon-globe"></i> <?php echo $this->Html->link('Custom Forms', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index')); ?></h3>
            <p>Create custom forms, so users can interact with your site how you want them to..</p>
        </div>
        <?php } ?>
        
        <div class="masonryBox tagConditions tagAdmin">
            <h3><i class="icon-globe"></i> <?php echo $this->Html->link('Conditions', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')); ?></h3>
            <p>Create customized actions for use in workflows.</p>
        </div>
        
		<?php if (in_array('Workflows', CakePlugin::loaded())) { ?>  
        <div class="masonryBox tagWorkflows tagAdmin">
            <h3><i class="icon-globe"></i> <?php echo $this->Html->link('Workflows', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index')); ?></h3>
            <p>Automate what happens after a condition is met.</p>
        </div>
        <?php } ?>
        
        <div class="masonryBox tagAdmin">
            <h3><i class="icon-globe"></i> <?php echo $this->Html->link('Enumerations', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index')); ?></h3>
            <p>Manage the labels that appear in system drop downs.</p>
        </div>
        
        <div class="masonryBox tagUpdates tagAdmin">
            <h3><i class="icon-globe"></i> Install Updates </h3>
            <p>Check for updates, install plugins, and  generally improve your site system.
            <p><?php echo $this->Html->link('Install Plugins', array('plugin' => null, 'controller' => 'install', 'action' => 'index')); ?></p>
			<p><?php echo $this->Form->create('', array('id' => 'updateForm')); echo $this->Form->hidden('Upgrade.all', array('value' => true)); echo $this->Form->submit('Check for Updates'); echo $this->Form->end(); ?></p>
        </div>
        
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
