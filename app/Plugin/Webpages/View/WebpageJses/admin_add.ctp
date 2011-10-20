<div class="webpageJses form">
<?php echo $this->Form->create('WebpageJs');?>
	<fieldset>
 		<legend><?php echo __('Admin Add Webpage Js', array('url' => array('controller' => 'webpage_jses'))); ?></legend>
	<?php
		echo $this->Form->input('webpage_id', array('empty' => true, 'after' => 'if empty then will be used for all templates'));
		echo $this->Form->input('name');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Webpage Jses', true), array('action' => 'index'));?></li>
	</ul>
</div>