<div class="tags form">
<?php echo $form->create('Tag');?>
	<fieldset>
 		<legend><?php __('Add Tag');?></legend>
	<?php
		echo $form->input('id');
		//echo $form->input('name');
		echo 'Ajax was removed, this needs to be fixed to work the the Js Helper';
		#echo $ajax->autocomplete('Tag.name');
	?>

	</fieldset>
<?php echo $form->end('Submit');?>
</div>