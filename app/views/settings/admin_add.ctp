<div class="settings form">
<?php echo $form->create('Setting');?>
	<fieldset>
 		<legend><?php __('Add Setting');?></legend>
	<?php
		echo $form->input('key');
		echo $form->input('value');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Settings', true), array('action' => 'index'));?></li>
	</ul>
</div>
