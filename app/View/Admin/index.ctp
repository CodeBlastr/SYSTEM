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

if (empty($runUpdates)) : ?>

    <div class="btn-group">
        <a href="#masonryBox" class="filterClick btn btn-default">All</a>
        <?php echo $this->Html->link(__('Pages'), '#tagPages', array('class' => 'filterClick btn btn-default')); ?>
        <?php echo CakePlugin::loaded('Media') ? $this->Html->link(__('Media'), '#tagMedia', array('class' => 'filterClick btn btn-default')) : null; ?>
        <?php echo CakePlugin::loaded('Comments') ? $this->Html->link(__('Discussion'), '#tagDiscussion', array('class' => 'filterClick btn btn-default')) : null; ?>
        <?php echo $this->Html->link(__('Themes'), '#tagThemes', array('class' => 'filterClick btn btn-default')); ?>
        <?php echo $this->Html->link(__('Settings'), '#tagAdmin', array('class' => 'filterClick btn btn-default')); ?>
    </div>

    <div class="masonry dashboard">
        <div class="masonryBox dashboardBox tagPages">
            <h3 class="title"><i class="glyphicon glyphicon-file"></i> <?php echo $this->Html->link('Pages', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'content')); ?></h3>
            <p>View, edit, delete, and create static content pages with text, graphics, video and/or audio. </p>
            <ul>
            	<li><?php echo $this->Html->link('List Pages', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'content')); ?></li>
            	<li><?php echo $this->Html->link('Add Page', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'add', 'content')); ?></li>
            	<li><?php echo $this->Html->link('Add Section', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'add', 'section')); ?> (eg. page with multiple pages)</li>
            	<li><?php echo $this->Html->link('Email Templates', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'email')); ?></li>
            </ul>
        </div>

        <div class="masonryBox dashboardBox tagThemes tagElements">
            <h3 class="title"><i class="glyphicon glyphicon-th-large"></i> <?php echo $this->Html->link('Widget Elements', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></h3>
            <p>Edit, delete, and create pages and multi-page elements. </p>
            <ul>
                <li><?php echo $this->Html->link('Widget Elements', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></li>
                <li><?php echo $this->Html->link('Menus', array('plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'index')); ?></li>
            </ul>
        </div>

        <?php if (CakePlugin::loaded('Media')) : ?>
        <div class="masonryBox dashboardBox tagMedia tagThemes">
            <h3 class="title"><i class="glyphicon glyphicon-cloud"></i> <?php echo $this->Html->link('File Managers', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'content')); ?></h3>
            <p>Edit, delete, and create images, documents, audio and video. </p>
            <ul>
                <li><?php echo $this->Html->link('Media Browser', array('plugin' => 'media', 'controller' => 'media_browser', 'action' => 'filebrowser')); ?>
                	<br><p>Create, Edit, Delete all Media that has been uploaded to the site</p></li>
                <li><?php echo $this->Html->link('Media Galleries', array('admin' => true, 'plugin' => 'media', 'controller' => 'media_galleries', 'action' => 'index')); ?>
      				<br><p>Create, Edit, manage your media galleries</p></li>
            </ul>
        </div>
        <?php endif; ?>

        <div class="masonryBox dashboardBox tagThemes">
            <h3 class="title"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $this->Html->link('Appearance', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'template')); ?></h3>
            <p>Manage the look and feel of your site.</p>
            <ul>
                <li><?php echo $this->Html->link('Templates', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'template')); ?></li>
                <li><?php echo $this->Html->link('Menus', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpage_menus', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Widget Elements', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'element')); ?></li>
                <li><?php echo $this->Html->link('Css Styles', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpage_csses', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Javascript', array('admin' => true, 'plugin' => 'webpages', 'controller' => 'webpage_jses', 'action' => 'index')); ?></li>
                <?php if (CakePlugin::loaded('Media')) : ?>
                <li><?php echo $this->Html->link('Image Files', array('admin' => true, 'plugin' => 'media', 'controller' => 'media', 'action' => 'images')); ?></li>
                <li><?php echo $this->Html->link('Document Files', array('admin' => true, 'plugin' => 'media', 'controller' => 'media', 'action' => 'files')); ?></li>
                <?php endif; ?>
            </ul>
        </div>

		<?php if (CakePlugin::loaded('Blogs')) : ?>
        <div class="masonryBox dashboardBox tagBlogs tagPages">
            <h3 class="title"><i class="glyphicon glyphicon-file"></i> <?php echo $this->Html->link('Blogs Dashboard', array('admin' => true, 'plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'dashboard')); ?></h3>
            <p>Create multiple blogs, and post new content.</p>
            <ul>
            	<?php if (!empty($blogs)) : ?>
            		<?php foreach ($blogs as $blog) : ?>
            			<?php echo __('<li>%s to %s</li>', $this->Html->link('Add Post', array('admin' => true, 'plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'add', $blog['Blog']['id'])), $this->Html->link($blog['Blog']['title'], array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'view', $blog['Blog']['id']))); ?>
            		<?php endforeach; ?>
            	<?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

		<?php if (CakePlugin::loaded('Comments')) : ?>
        <div class="masonryBox dashboardBox tagComments tagDiscussion">
            <h3 class="title"><i class="glyphicon glyphicon-comment"></i> <?php echo $this->Html->link('Comments', array('admin' => true, 'plugin' => 'comments', 'controller' => 'comments', 'action' => 'index')); ?></h3>
            <p>See and manage the discussions going on.</p>
        </div>
        <?php endif; ?>

        <?php if (CakePlugin::loaded('Properties')) : ?>
        <div class="masonryBox dashboardBox tagComments tagDiscussion">
            <h3 class="title"><i class="glyphicon glyphicon-tasks"></i> <?php echo $this->Html->link('Properties', array('admin' => true, 'plugin' => 'properties', 'controller' => 'properties', 'action' => 'dashboard')); ?></h3>
            <ul>
                <li><?php echo $this->Html->link('See all properties', array('admin' => false, 'plugin' => 'properties', 'controller' => 'properties', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Add Properties', array('admin' => true, 'plugin' => 'properties', 'controller' => 'properties', 'action' => 'add')); ?></li>
            </ul>
            <p>See and manage property listings</p>
        </div>
        <?php endif; ?>

		<?php if (CakePlugin::loaded('Galleries')) : ?>
        <div class="masonryBox dashboardBox tagGalleries tagMedia">
            <h3 class="title"><i class="glyphicon glyphicon-picture"></i> <?php echo $this->Html->link('Galleries', array('admin' => true, 'plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'dashboard', 'admin' => 'true')); ?></h3>
            <p>Add and edit image and video galleries</p>
        </div>
        <?php endif; ?>

		<?php if (CakePlugin::loaded('Jobs')) : ?>
        <div class="masonryBox dashboardBox tagPages">
            <h3 class="title"><i class="glyphicon glyphicon-picture"></i> <?php echo $this->Html->link('Manage Jobs', array('admin' => true,'plugin' => 'jobs','controller' => 'jobs', 'action' => 'index')); ?></h3>
            <p><?php echo $this->Html->link('Add Job', array('admin' => true,'plugin' => 'jobs','controller' => 'jobs', 'action' => 'add')); ?></p>
        </div>
        <?php endif; ?>

        <div class="masonryBox dashboardBox tagMedia">
            <h3 class="title"><i class="glyphicon glyphicon-star-empty"></i> Favicon</h3>
            <p>Add the little icon that appears in browser title bars. </p>
          	<?php echo $this->Form->create('Admin', array('type' => 'file')); ?>
			<?php echo $this->Form->input('icon', array('type' => 'file', 'label' => false)); ?>
			<?php echo $this->Form->end('Upload'); ?>
        </div>

        <?php if ($this->request->query['s'] == 'f9823uf9283u9283u') : ?>
		<div class="masonryBox dashboardBox tagMedia">
           	 <h3 class="title"><i class="glyphicon glyphicon-floppy-save"></i> Site Backup</h3>
            	<p>Export your site and download as a zipfile.</p>
          		<?php echo $this->Form->create('Admin'); ?>
				<?php echo $this->Form->hidden('export', array('value' => true)); ?>
				<?php echo $this->Form->end('Save Backup'); ?>
        </div>
        <?php endif; ?>

		<?php if (CakePlugin::loaded('Categories')) : ?>
        <div class="masonryBox dashboardBox tagText tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-tasks"></i> <?php echo $this->Html->link('Categories', array('admin' => 1, 'plugin' => 'categories', 'controller' => 'categories', 'action' => 'dashboard')); ?></h3>
            <p>Categorize anything.  Move, reorder, add, edit categories. <?php echo $this->Html->link('Dashboard', array('admin' => 1, 'plugin' => 'categories', 'controller' => 'categories', 'action' => 'dashboard'), array('class' => 'btn btn-default btn-mini btn-xs')); ?></p>
        </div>
        <?php endif; ?>
        
        <div class="masonryBox dashboardBox tagText tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-tasks"></i> <?php echo $this->Html->link('Permanent URL\'s', array('admin' => 1, 'plugin' => false, 'controller' => 'aliases', 'action' => 'index')); ?></h3>
            <p>Manage your site's url aliases.</p>
            <p><?php echo $this->Html->link('Build Sitemap', array('plugin' => false, 'controller' => 'aliases', 'action' => 'sitemap')); ?></p>
           	<?php echo file_exists(ROOT . DS . SITE_DIR . DS . 'Locale' . DS .'View' . DS . 'webroot' . DS . 'sitemap.xml') ? $this->Html->link('<p>View Sitemap</p>', '/sitemap.xml', array('escape' => false)) : null; ?>
        </div>

		<?php if (CakePlugin::loaded('Tags')) : ?>
        <div class="masonryBox dashboardBox tagTags tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-tags"></i> <?php echo $this->Html->link('Tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')); ?></h3>
            <p>Tag anything.  Move, reorder, add, edit tags.</p>
        </div>
        <?php endif; ?>

        <div class="masonryBox dashboardBox tagPrivileges tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-lock"></i> <?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'index')); ?></h3>
            <p>Control what content your different user roles can see. <?php echo $this->Html->link('Manage Privileges', array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'index'), array('class' => 'btn btn-default btn-mini btn-xs')); ?></p>
        </div>

        <div class="masonryBox dashboardBox tagSettings tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-wrench"></i> <?php echo $this->Html->link('Settings', array('plugin' => null, 'controller' => 'settings', 'action' => 'index')); ?></h3>
            <p>Configure your system with customizable variables.</p>
        </div>

		<?php if (CakePlugin::loaded('Forms')) : ?>
        <div class="masonryBox dashboardBox tagForms tagPages">
            <h3 class="title"><i class="glyphicon glyphicon-send"></i> <?php echo $this->Html->link('Custom Forms <small>(old)</small>', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index'), array('escape' => false)); ?></h3>
            <p>Create custom forms, so users can interact with your site how you want them to..</p>
        </div>
        <?php endif; ?>

        <?php if (CakePlugin::loaded('Answers')) : ?>
        <div class="masonryBox dashboardBox tagForms tagPages">
            <h3 class="title"><i class="glyphicon glyphicon-send"></i> <?php echo $this->Html->link('Custom Forms', array('plugin' => 'answers', 'controller' => 'answers', 'action' => 'index')); ?></h3>
            <p>Create custom forms using the Drag and Drop Form Buildrr.</p>
            <li><?php echo $this->Html->link('View Form Submissions', array('plugin' => 'answers', 'controller' => 'answersSubmissions')) ?></li>
        </div>
        <?php endif; ?>

        <div class="masonryBox dashboardBox tagConditions tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-filter"></i> <?php echo $this->Html->link('Conditions', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')); ?></h3>
            <p>Create customized actions for use in workflows.</p>
        </div>

		<?php if (CakePlugin::loaded('Workflows')) : ?>
        <div class="masonryBox dashboardBox tagWorkflows tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-forward"></i> <?php echo $this->Html->link('Workflows', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index')); ?></h3>
            <p>Automate what happens after a condition is met.</p>
        </div>
        <?php endif; ?>

        <div class="masonryBox dashboardBox tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-list"></i> <?php echo $this->Html->link('Enumerations', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index')); ?></h3>
            <p>Manage the labels that appear in system drop downs.</p>
        </div>

        <div class="masonryBox dashboardBox tagUpdates tagAdmin">
            <h3 class="title"><i class="glyphicon glyphicon-download-alt"></i> Install Updates </h3>
            <p>Check for updates, install plugins, and  generally improve your site system.
            <p><?php echo $this->Html->link('Install Plugins', array('plugin' => null, 'controller' => 'install', 'action' => 'index'), array('class' => 'btn btn-default')); ?></p>
            <p><?php echo $this->Html->link('Uninstall Plugins', array('plugin' => null, 'controller' => 'install', 'action' => 'uninstall'), array('class' => 'btn btn-danger')); ?></p>
			<p><?php echo $this->Form->create('', array('id' => 'updateForm')); echo $this->Form->hidden('Update.index', array('value' => true)); echo $this->Form->submit('Check for Updates'); echo $this->Form->end(); ?></p>
        </div>

        <?php if (CakePlugin::loaded('Projects')) : ?>
        <div class="masonryBox dashboardBox tagProjects tagTimesheets">
            <h3 class="title"><i class="glyphicon glyphicon-globe"></i> <?php echo $this->Html->link('Projects', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index')); ?> </h3>
            <p>Setup projects, with messages, tasks, people and track time.</p>
            <ul>
                <li><?php echo $this->Html->link('Timesheets', array('plugin' => 'timesheets', 'controller' => 'timesheets', 'action' => 'index')); ?></li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (CakePlugin::loaded('Tasks')) : ?>
        <div class="masonryBox dashboardBox tagProjects tagTasks">
            <h3 class="title"><i class="glyphicon glyphicon-fire"></i> <?php echo $this->Html->link('Tasks', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'my')); ?> </h3>
            <p>See and manage all to-do tasks whether they're for a project a contact or anything else.</p>
        </div>
        <?php endif; ?>

        <?php if (CakePlugin::loaded('Events')) : ?>
        <div class="masonryBox dashboardBox">
            <h3 class="title"><i class="glyphicon glyphicon-calendar"></i> <?php echo $this->Html->link('Events', array('admin' => true, 'plugin' => 'events', 'controller' => 'events', 'action' => 'index')); ?> </h3>
            <p>See and manage event listings.</p>
            <ul>
                <li><?php echo $this->Html->link('Add Event', array('admin' => true, 'plugin' => 'events', 'controller' => 'events', 'action' => 'add')); ?></li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (CakePlugin::loaded('Invoices')) : ?>
        <div class="masonryBox dashboardBox">
            <h3 class="title"><i class="glyphicon glyphicon-barcode"></i> <?php echo $this->Html->link('Invoices', array('admin' => true, 'plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'index')); ?> </h3>
            <p>
            	Manage invoices<br>
	            <?php echo $this->Html->link('All Invoices', array('admin' => true, 'plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'index')); ?><br>
	           	<?php echo $this->Html->link('Add Invoice', array('admin' => true, 'plugin' => 'invoices', 'controller' => 'invoices', 'action' => 'add')); ?>
	            <hr>
	            <?php echo $this->Html->link('Reusable Items', array('admin' => true, 'plugin' => 'invoices', 'controller' => 'invoice_items', 'action' => 'index')); ?><br>
	            <?php echo $this->Html->link('Add Reusable Item', array('admin' => true, 'plugin' => 'invoices', 'controller' => 'invoice_items', 'action' => 'add')); ?>
            </p>
        </div>
        <?php endif; ?>
        
        <?php if (CakePlugin::loaded('Products') && !CakePlugin::loaded('Transactions')) : ?>
        <div class="masonryBox dashboardBox">
            <h3 class="title"><i class="glyphicon glyphicon-barcode"></i> <?php echo $this->Html->link(__('Products'), array('admin' => true, 'plugin' => 'products', 'controller' => 'products', 'action' => 'dashboard'), array('escape' => false)); ?> </h3>
            <p>
            	<?php echo $this->Html->link('Products Dashboard', array('admin' => true, 'plugin' => 'products', 'controller' => 'products', 'action' => 'dashboard')); ?><br>
	           	<?php echo $this->Html->link('Add Product', array('admin' => true, 'plugin' => 'products', 'controller' => 'products', 'action' => 'add')); ?>
            </p>
        </div>
        <?php elseif (CakePlugin::loaded('Transactions')) : ?>
        <div class="masonryBox dashboardBox">
            <h3 class="title"><i class="glyphicon glyphicon-barcode"></i> <?php echo $this->Html->link(__('Ecommerce Dashboard'), array('admin' => true, 'plugin' => 'transactions', 'controller' => 'transactions', 'action' => 'dashboard'), array('escape' => false)); ?> </h3>
            <p>
            	<?php echo $this->Html->link('Ecommerce Dashboard', array('admin' => true, 'plugin' => 'transactions', 'controller' => 'transactions', 'action' => 'dashboard')); ?><br>
	           	<?php echo $this->Html->link('Add Product', array('admin' => true, 'plugin' => 'products', 'controller' => 'products', 'action' => 'add')); ?>
            </p>
        </div>
        <?php endif; ?>

        <?php if (CakePlugin::loaded('Wizards')) : ?>
        <div class="masonryBox dashboardBox">
            <h3 class="title"><i class="glyphicon glyphicon-info-sign"></i> <?php echo $this->Html->link('Wizards', array('plugin' => 'wizards', 'controller' => 'wizards')); ?> </h3>
            <p>Create and edit Pop Up Help alerts.</p>
            <ul>
                <li><?php echo $this->Html->link('Create Wizard', array('plugin' => 'wizards', 'controller' => 'wizards', 'action' => 'add')); ?></li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (CakePlugin::loaded('Campaigns')) : ?>
        <div class="masonryBox dashboardBox">
            <h3 class="title"><i class="glyphicon glyphicon-tower"></i> <?php echo $this->Html->link('Campaigns', array('admin' => true, 'plugin' => 'campaigns', 'controller' => 'campaigns')); ?> </h3>
            <p>Create and manage Campaigns.</p>
            <ul>
                <li><?php echo $this->Html->link('Campaign Results', array('admin' => true, 'plugin' => 'campaigns', 'controller' => 'campaign_results')); ?></li>
                <li><?php echo $this->Html->link('Create New Campaign', array('admin' => true, 'plugin' => 'campaigns', 'controller' => 'campaigns', 'action' => 'add')); ?></li>
            </ul>
        </div>
        <?php endif; ?>

    </div>
<?php else : ?>
	<div id="databaseUpgrades">
		<?php $complete = CakeSession::read('Updates.complete'); ?>
		<?php echo $this->Form->create('', array('id' => 'autoUpdateForm')); ?>
		<?php echo $this->Form->hidden('Upgrade.all', array('value' => true)); ?>
		<?php echo $this->Form->end(); ?>
    	<table class="table table-bordered">
      	<?php if (CakeSession::read('Updates.last')) : ?>
      		<?php foreach (array_reverse(CakeSession::read('Updates.last')) as $table => $action) : ?>
				<?php switch ($action) {
					case ('up to date'):
						$class = ' label-primary';
						break;
					case ('updated'):
						$class = ' label-success';
						break;
					default:
						$class = ' label-default';
						break;
				} ?>
				<tr><td>`<?php echo $table; ?>`</td><td><span class="label<?php echo $class; ?>"><?php echo $action; ?></span></td></tr>
      		<?php endforeach; ?>
		<?php endif; ?>
    	</table>
	</div>

	<?php $complete = CakeSession::read('Updates.complete'); ?>
    <?php if (CakeSession::read('Updates') && empty($complete)) :  ?>
    <script type="text/javascript">
        $(function() {
       		$("#autoUpdateForm").submit();
        });
	</script>
	<?php endif; ?>
<?php endif; ?>

<?php
// set the contextual breadcrumb items
// $this->set('context_crumbs', array(
	// 'crumbs' => array(
		// $page_title_for_layout
		// )
	// ));