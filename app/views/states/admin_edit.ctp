<div class="states form">
<?php echo $form->create('State');?>
	<fieldset>
 		<legend><?php __('Edit State');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('country_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('State.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('State.id'))); ?></li>
		<li><?php echo $html->link(__('List States', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Countries', true), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Country', true), array('controller' => 'countries', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Addresses', true), array('controller' => 'contact_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Address', true), array('controller' => 'contact_addresses', 'action' => 'add')); ?> </li>
	</ul>
</div>
