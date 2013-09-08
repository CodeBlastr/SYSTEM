<div class="webpages form">
    <fieldset>
		<?php echo $this->Form->create('Template');?>
    	<?php echo $this->Form->input('Template.layout'); ?>
    	<?php echo $this->Form->input('Template.demo'); ?>
    	<?php echo $this->Form->input('Template.is_usable', array('type' => 'hidden')); ?>
    	<?php echo $this->Form->input('Template.icon'); ?>
    	<?php echo $this->Form->input('Template.description'); ?>
		<?php echo $this->Form->input('Template.install', array('disabled' => 'disabled', 'label' => 'Snippet of the serialized template data')); ?>
		<?php echo $this->Form->end('Submit');?>
	</fieldset>
</div>