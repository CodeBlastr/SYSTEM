<div class="countries form">
<?php echo $form->create('Country');?>
	<fieldset>
 		<legend><?php __('Edit Country');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Country.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Country.id'))); ?></li>
		<li><?php echo $html->link(__('List Countries', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Contact Addresses', true), array('controller' => 'contact_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Address', true), array('controller' => 'contact_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List States', true), array('controller' => 'states', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New State', true), array('controller' => 'states', 'action' => 'add')); ?> </li>
	</ul>
</div>
