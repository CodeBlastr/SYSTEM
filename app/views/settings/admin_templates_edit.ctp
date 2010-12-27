<div class="temlates form">
<?php echo $form->create('Template', array('url' => '/admin/settings/templates_edit/'. $this->data['Template']['id'] + 1));?>
	<fieldset>
 		<legend><?php __('Edit Template');?></legend>
	<?php
		echo $form->input('template_id', array('type' => 'text'));
		echo $form->input('plugin');
		echo $form->input('controller');
        echo $form->input('action');
        echo $form->input('parameter');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'templates_delete', $form->value('Template.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Template.id'))); ?></li>
		<li><?php echo $html->link(__('List Settings', true), array('action' => 'templates'));?></li>
	</ul>
</div>
