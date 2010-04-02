<div class="wikiContents form">
<h2><?php if (!empty($this->params['pass'][0])){ echo str_replace('_', ' ', $this->params['pass'][1]); } ?></h2>
<?php echo $form->create('WikiContent');?>
	<fieldset>
 		<legend><?php __('Edit WikiContent');?></legend>
	<?php
		echo $form->input('id');
	if (!empty($this->params['pass'][0])) {
		echo $form->input('WikiPage.wiki_id', array('type' => 'hidden', 'value' => $this->params['pass'][0]));
		echo $form->input('WikiPage.title', array('type' => 'hidden', 'value' => $this->params['pass'][1]));
	} else {
		echo $form->input('WikiPage.title');
	}
		echo $form->input('text');
		echo $form->input('comments');
		echo $form->input('version', array('type' => 'hidden'));
		
		// creating a new project related wiki
		echo $form->input('ProjectsWiki.project_id', array('type' => 'hidden', 'value' => $this->params['named']['project_id']));
		echo $form->input('wiki_page_id', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<!--div class="actions">
	<ul>
		<li><?php #echo $html->link(__('New Wiki Page', true), array('controller' => 'wiki_contents', 'action' => 'edit', $this->params['pass'][0])); ?> </li>
	</ul>
</div-->