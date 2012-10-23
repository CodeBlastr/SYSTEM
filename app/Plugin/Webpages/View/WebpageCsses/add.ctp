<div class="webpageCsses form">
<?php echo $this->Form->create('WebpageCss');?>
	<fieldset>
 		<legend><?php echo __('Admin Add Webpage Css'); ?></legend>
	<?php
		echo $this->Form->input('webpage_id', array('empty' => true, 'after' => 'if empty then will be used for all templates'));
		echo $this->Form->input('type');
		echo $this->Form->input('name');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php
echo $this->Element('scaffolds/index', array('data' => $webpageCsses));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Css',
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'webpage_csses', 'action' => 'index')),
			)
		),
	)));