<div class="job estimate form">
	<?php
	echo $this->Form->create(); ?>
	<fieldset>
		<?php 
		echo $this->Form->input('Estimate.model', array('type' => 'hidden', 'value' => 'Job')); 
		echo $this->Form->input('Estimate.foreign_key', array('type' => 'hidden', 'value' => $job['Job']['id'])); 
		echo $this->Form->input('Estimate.total', array('label' => 'Bid Value (XXXX.XX format)')); 
		echo $this->Form->input('Estimate.description', array('type' => 'richtext')); ?>
	</fieldset>
  	<?php echo $this->Form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('View %s', $job['Job']['title']), array('action' => 'view', $job['Job']['id'])),
			)
		),
	))); ?>