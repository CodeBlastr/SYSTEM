<div class="webpageJses form">
<?php echo $this->Form->create('WebpageJs', array('url' => array('controller' => 'webpage_jses')));?>
	<fieldset>
	<?php
		echo $this->Form->input('WebpageJs.id');
		echo $this->Form->input('WebpageJs.webpage_id', array('label' => 'Template <small>(if empty, used with all templates)</small>.', 'empty' => true));
		echo $this->Form->input('WebpageJs.name');
		echo $this->Form->input('WebpageJs.is_requested', array('label' => 'Load manually? (advanced users)'));
		echo $this->Form->input('WebpageJs.content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Jses',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('WebpageJs.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('WebpageJs.id'))),
			$this->Html->link(__('List Webpage Jses', true), array('action' => 'index')),
			)
		),
	))); ?>