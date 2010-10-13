<div class="userGroups form">
<?php echo $form->create('UserGroup');?>
	<fieldset>
 		<legend><?php __('Edit UserGroup');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('UserGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('UserGroup.id'))); ?></li>
		<li><?php echo $html->link(__('List UserGroups', true), array('action' => 'index'));?></li>
	</ul>
</div>
