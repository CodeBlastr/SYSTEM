<div class="wikiContents form">
<?php echo $form->create('WikiContent');?>
	<fieldset>
 		<legend><?php __('Add WikiContent');?></legend>
	<?php
		echo $form->input('text');
		echo $form->input('comments');
		echo $form->input('version');
		echo $form->input('wiki_page_id');
		echo $form->input('creator_id');
		echo $form->input('modifier_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List WikiContents', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Wiki Pages', true), array('controller' => 'wiki_pages', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Wiki Page', true), array('controller' => 'wiki_pages', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
