<div class="contactActivities form">
<?php echo $form->create('ContactActivity');?>
	<fieldset>
 		<legend><?php __('Add ContactActivity');?></legend>
	<?php
		echo $form->input('parent_id');
		echo $form->input('contact_activity_type_id');
		echo $form->input('name');
		echo $form->input('description');
		echo $form->input('contact_id');
		echo $form->input('creator_id');
		echo $form->input('modifier_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List ContactActivities', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Contact Activities', true), array('controller' => 'contact_activities', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Parent', true), array('controller' => 'contact_activities', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity Types', true), array('controller' => 'contact_activity_types', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Type', true), array('controller' => 'contact_activity_types', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity Media', true), array('controller' => 'contact_activity_media', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Activity User Groups', true), array('controller' => 'contact_activity_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Activity User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
