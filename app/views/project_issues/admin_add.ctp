<div class="projectIssues form">
<?php echo $form->create('ProjectIssue');?>
	<fieldset>
 		<legend><?php __('Add ProjectIssue');?></legend>
	<?php
		echo $form->input('contact_activity_type_id', array('after' =>  ' '.$html->link(__('Edit', true), array('controller' => 'contact_activity_types', 'action' => 'index')))); 
		echo $form->input('name'); 
		echo $form->input('description');
		echo $form->hidden('project_id', array('value' => $this->params['url']['project_id']));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
