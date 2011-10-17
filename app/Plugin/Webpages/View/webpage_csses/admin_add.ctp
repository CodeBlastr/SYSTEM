<div class="webpageCsses form">
<?php echo $this->Form->create('WebpageCss');?>
	<fieldset>
 		<legend><?php __('Admin Add Webpage Css'); ?></legend>
	<?php
		echo $this->Form->input('webpage_id', array('empty' => true, 'after' => 'if empty then will be used for all templates'));
		echo $this->Form->input('type');
		echo $this->Form->input('name');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Webpage Csses', true), array('action' => 'index'));?></li>
	</ul>
</div>