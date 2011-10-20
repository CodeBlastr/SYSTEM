<div class="webpageJses form">
<?php echo $this->Form->create('WebpageJs', array('url' => array('controller' => 'webpage_jses')));?>
	<fieldset>
 		<legend><?php echo __('Admin Edit Webpage Js', array('url' => array('controller' => 'webpage_jses'))); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('WebpageJs.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('WebpageJs.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Webpage Jses', true), array('action' => 'index'));?></li>
	</ul>
</div>