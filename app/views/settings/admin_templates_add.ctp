<div class="templates form">
<?php echo $form->create('Template', array('url' => '/admin/settings/templates_add/'));?>
	<fieldset>
 		<legend><?php __('Add Template');?></legend>
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
		<li><?php echo $html->link(__('List Settings', true), array('action' => 'templates'));?></li>
	</ul>
</div>