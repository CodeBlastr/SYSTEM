<div class="settings form">
<?php echo $this->Form->create('Setting'); ?>
	<fieldset>
 		<legend><?php __('Edit Setting');?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type');
		echo $this->Form->input('name');
		echo $this->Form->input('value');
		echo $this->Form->input('description');
		echo $this->Form->end('Submit');
		?>
	</fieldset>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Setting.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Setting.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Settings', true), array('action' => 'index'));?></li>
	</ul>
</div>
