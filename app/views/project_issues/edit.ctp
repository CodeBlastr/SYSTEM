<div class="projectIssues form">
<?php echo $form->create('ProjectIssue');?>
	<fieldset>
 		<legend><?php __('Edit ProjectIssue');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('parent_id');
		echo $form->input('contact_activity_type_id');
		echo $form->input('name');
		echo $form->input('description');
		echo $form->input('project_id');
		echo $form->input('creator_id');
		echo $form->input('modifier_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('ProjectIssue.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ProjectIssue.id'))); ?></li>
		<li><?php echo $html->link(__('List ProjectIssues', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Project Issues', true), array('controller' => 'project_issues', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Parent', true), array('controller' => 'project_issues', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue Types', true), array('controller' => 'contact_activity_types', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Type', true), array('controller' => 'contact_activity_types', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Projects', true), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue Media', true), array('controller' => 'contact_activity_media', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue User Groups', true), array('controller' => 'contact_activity_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
