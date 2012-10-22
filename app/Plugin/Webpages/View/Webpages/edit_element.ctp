<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
    
	<fieldset>
    	<?php
		echo $this->Form->input('Webpage.id');
		echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'value' => 'element'));
		echo $this->Form->input('Webpage.name', array('label' => 'Internal Element Name'));
		echo $this->Form->input('Webpage.content', array('type' => 'richtext')); ?>
	</fieldset>
    
	<fieldset>
		<legend class="toggleClick"><?php echo __('<span class="hoverTip" title="User role site privileges are used by default. Choose an option to restrict access to only the chosen group for this specific element.">Access Restrictions (optional)</span>');?></legend>
    	<?php 
		echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $userRoles)); ?>
    </fieldset>
    
	<?php echo $this->Form->end('Save Webpage');?>
</div>

<?php
$menuItems = array(
	$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index', 'element')),
	$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'element'), array('title' => 'Add Webpage')),
	$this->Html->link(__('View'), array('controller' => 'webpages', 'action' => 'view', $this->request->data['Webpage']['id'])),
	$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Webpage.id'))),
	$this->Html->link(__('Add Child'), array('controller' => 'webpages', 'action' => 'add', 'element', $this->request->data['Webpage']['id']), array('title' => 'Add Child'))
	);

$this->set('context_menu', array('menus' => array(
	  array('heading' => 'Webpages',
		'items' => $menuItems
			)
	  ))); ?>
