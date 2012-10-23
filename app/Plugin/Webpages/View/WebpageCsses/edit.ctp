<div class="webpageCsses form">
<?php echo $this->Form->create('WebpageCss');?>
	<fieldset>
 		<legend><?php echo __('Admin Edit Webpage Css'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('webpage_id', array('label' => 'Template <small>(if empty, used with all templates)</small>.', 'empty' => true));
		echo $this->Form->input('type');
		echo $this->Form->input('name');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Csses',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('WebpageCss.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('WebpageCss.id'))),
			$this->Html->link(__('List Webpage Csses', true), array('action' => 'index')),
			)
		),
	)));
?>