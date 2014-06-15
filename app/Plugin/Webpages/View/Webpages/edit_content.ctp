<div class="clearfix">
	<?php echo $this->Form->create('Webpage', array('type' => 'file'));?>
	<div class="clearfix">
		<div class="webpages form col-md-9">
			<fieldset>
		    	<?php echo $this->Form->input('Webpage.id'); ?>
		    	<?php echo $this->Form->input('Webpage.type', array('type' => 'hidden')); ?>
				<?php echo $this->Form->input('Webpage.name', array('label' => 'Internal Page Name')); ?>
				<?php echo CakePlugin::loaded('Media') ? __('<hr>%s</h4>', $this->Element('Media.selector', array('media' => $this->request->data['Media'], 'multiple' => true))): null; ?>
				<?php echo $this->Form->input('Webpage.content', array('type' => 'richtext', 'label' => '')); ?>
			</fieldset>
		</div>
		<div class="col-md-3" id="webpages-sidebar">
			<div class="panel"><?php // this extra div is a bootstra 3 bug, that appears fixed on github but not in the dist yet ?>
				<h4 data-toggle="collapse" data-target=".seo-group" data-parent="#webpages-sidebar"><?php echo __('Search Engine Optimization');?></h4>
				<hr />
				<div class="seo-group collapse in">
			    	<?php echo $this->Element('forms/alias', array('formId' => '#WebpageAddForm', 'nameInput' => '#WebpageName', 'dataDisplay' => '[for=WebpageName]')); // must have the alias behavior attached to work ?>
			    	<?php echo $this->Form->input('Webpage.title', array('label' => 'SEO Title')); ?>
					<?php echo $this->Form->input('Webpage.keywords', array('label' => 'SEO Keywords', 'type' => 'text')); ?>
					<?php echo $this->Form->input('Webpage.description', array('label' => 'SEO Description', 'type' => 'text')); ?>
				</div>
				
				<h4 data-toggle="collapse" data-target=".img-group" data-parent="#webpages-sidebar"><?php echo __('Featured Image'); ?></h4>
				<hr />
				<div class="img-group collapse">
					<?php echo $this->element('Galleries.thumb', array('model' => 'Webpage', 'foreignKey' => $this->request->data['Webpage']['id'])); ?>
					<?php echo $this->Form->input('GalleryImage.is_thumb', array('type' => 'hidden', 'value' => 1)); ?>
					<?php echo $this->Form->input('GalleryImage.filename', array('type' => 'file')); ?>
				</div>
				
				<h4 data-toggle="collapse" data-target=".menu-group" data-parent="#webpages-sidebar">Navigation Settings</h4>
				<hr />
				<div class="menu-group collapse">
					<?php // not tested with editing menus yet // echo $this->Form->input('WebpageMenuItem.parent_id', array('empty' => '-- Select Menu --', 'label' => __('Add to Menu'))); ?>
					<?php // not tested with editing menus yetnot fileed yet // echo $this->Form->input('WebpageMenuItem.item_text', array('label' => __('Menu Link Text'))); ?>
					<?php echo $this->Form->input('Webpage.Meta.context_menu', array('empty' => '-- Select -- ', 'options' => $menus)); ?>
				</div>
	
				<h4 data-toggle="collapse" data-target=".access-group" data-parent="#webpages-sidebar"><?php echo __('<span class="hoverTip" title="User role site privileges are used by default. Choose an option to restrict access to only the chosen group for this specific page.">Access</span>');?></h4>
				<hr />
				<div class="access-group collapse">
					<p>Check these boxes to restrict access to only the chosen group(s) for this specific page.</p>
			    	<?php echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $userRoles)); ?>
			    	<?php echo $this->Form->input('Webpage.parent_id', array('label' => 'Convert to Subpage', 'empty' => '-- Select --')); ?>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end('Edit Page');?>
</div>

<?php 
// set the contextual breadcrumb items
$parent = !empty($this->request->data['Parent']['name']) ? $this->Html->link($this->request->data['Parent']['name'], array('action' => 'index', 'section', $this->request->data['Parent']['id'])) : null; 
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$this->Html->link(__('All Pages'), array('action' => 'index', 'content')),
	$parent,
	$page_title_for_layout,
)));

$menuItems = array(
	$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index', 'content')),
	$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'content'), array('title' => 'Add Webpage')),
	$this->Html->link(__('View'), array('controller' => 'webpages', 'action' => 'view', $this->request->data['Webpage']['id'])),
	$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete %s?'), $this->Form->value('Webpage.name'))),
	);
	
$this->set('context_menu', array('menus' => array(
	  array('heading' => 'Webpages',
		'items' => $menuItems
			)
	  )));