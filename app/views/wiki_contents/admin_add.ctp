<div class="wikiContents form">
<h2><?php echo str_replace('_', ' ', $this->params['pass'][1]); ?></h2>
<?php echo $form->create('WikiContent');?>
	<fieldset>
 		<legend><?php __('Edit WikiContent');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('text');
		echo $form->input('comments');
		echo $form->input('version', array('type' => 'hidden'));
		echo $form->input('WikiPage.wiki_id', array('type' => 'hidden', 'value' => $this->params['pass'][0]));
		echo $form->input('WikiPage.title', array('type' => 'hidden', 'value' => $this->params['pass'][1]));
		echo $form->input('wiki_page_id', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
