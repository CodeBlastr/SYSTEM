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
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpage Csses',
		'items' => array(
			$this->Html->link(__('List Webpage Csses', true), array('action' => 'index')),
			)
		),
	)));
?>