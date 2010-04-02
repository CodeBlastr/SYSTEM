<div class="wikiContents form">
<?php echo $form->create('WikiContent');?>
	<fieldset>
 		<legend><?php __('Edit WikiContent');?></legend>
	<?php
		echo $form->input('WikiPage.title');
		echo $form->input('id');
		echo $form->input('text');
		echo $form->input('comments');
		echo $form->input('version', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<!-- div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Wiki Page', true), array('controller' => 'wiki_pages', 'action' => 'add')); ?> </li>
	</ul>
</div -->