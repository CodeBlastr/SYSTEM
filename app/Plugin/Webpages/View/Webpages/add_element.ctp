<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
	<?php echo $this->Form->hidden('Override.redirect', array('value' => '/admin/webpages/webpages/index/element')); ?>
	<fieldset>
    	<?php echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'value' => 'element')); ?>
    	<?php echo $this->Form->input('Webpage.name', array('label' => 'Internal Element Name')); ?>
    	<?php echo $this->Form->input('Webpage.content', array('type' => 'richtext')); ?>
	</fieldset>
    
	<fieldset>
		<legend class="toggleClick"><?php echo __('<span class="hoverTip" title="User role site privileges are used by default. Choose an option to restrict access to only the chosen group for this specific element.">Access Restrictions (optional)</span>');?></legend>
    	<?php 
		echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $userRoles)); ?>
    </fieldset>
    
	<?php echo $this->Form->end('Save Element');?>
</div>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	$this->Html->link(__('All Elements'), array('action' => 'index', 'element')),
	'Element Builder'
)));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			 $this->Html->link(__('List'), array('action' => 'index', 'element')),
			 $this->Html->link(__('Advanced Editor'), array('action' => 'add', 'element', '?' => array('advanced' => true))),
			 )
		)
	)));