<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
    
	<fieldset>
    	<?php
		echo $this->Form->input('Webpage.id');
		echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'value' => 'content'));
		echo $this->Form->input('Webpage.name', array('label' => 'Internal Page Name'));
		echo $this->Form->input('Webpage.content', array('type' => 'richtext')); ?>
	</fieldset>
    
	<fieldset>
		<legend class="toggleClick"><?php echo __('Search Engine Optimization');?></legend>
    	<?php 
		echo $this->Form->input('Alias.name', array('label' => 'SEO Url (unique)'));
		echo $this->Form->input('Alias.plugin', array('type' => 'hidden', 'value' => 'webpages'));
		echo $this->Form->input('Alias.controller', array('type' => 'hidden', 'value' => 'webpages'));
		echo $this->Form->input('Alias.action', array('type' => 'hidden', 'value' => 'view'));
		echo $this->Form->input('Webpage.title', array('label' => 'SEO Title'));
		echo $this->Form->input('Webpage.keywords', array('label' => 'SEO Keywords'));
		echo $this->Form->input('Webpage.description', array('label' => 'SEO Description')); ?>
    </fieldset>
    
	<fieldset>
		<legend class="toggleClick"><?php echo __('<span class="hoverTip" title="User role site privileges are used by default. Choose an option to restrict access to only the chosen group for this specific page.">Access Restrictions (optional)</span>');?></legend>
    	<?php 
		echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $userRoles)); ?>
    </fieldset>
    
	<?php echo $this->Form->end('Save Webpage');?>
</div>

<?php
$menuItems = array(
	$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index')),
	$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add'), array('title' => 'Add Webpage')),
	$this->Html->link(__('View'), array('controller' => 'webpages', 'action' => 'view', $this->request->data['Webpage']['id'])),
	$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete %s?'), $this->Form->value('Webpage.name'))),
	);
	
$this->set('context_menu', array('menus' => array(
	  array('heading' => 'Webpages',
		'items' => $menuItems
			)
	  ))); ?>
