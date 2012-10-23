<div class="webpageJses form">
<?php echo $this->Form->create('WebpageJs', array('url' => array('controller' => 'webpage_jses')));?>
	<fieldset>
	<?php
		echo $this->Form->input('webpage_id', array('label' => 'Template <small>(if empty, used with all templates)</small>.', 'empty' => true));
	echo $this->Form->input('name');
	echo $this->Form->input('content');	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Jses',
		'items' => array(
			$this->Html->link(__('List'), array('action' => 'index')),
			)
		),
	))); ?>