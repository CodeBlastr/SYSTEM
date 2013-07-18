<div class="contact form"> <?php echo $this->Form->create('Contact');?>
  <fieldset>
    <?php
	 echo $this->Form->hidden('Contact.is_company', array('value' => 0));
	 echo $this->Form->input('Employer', array('label' => 'Which company is this person related to?', 'type' => 'select'));
	 echo $this->Form->input('Contact.id', array('type' => 'select', 'options' => $people, 'label' => 'Employee'));	?>
  </fieldset>
  <?php echo $this->Form->end('Submit');?>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Companies',
		'items' => array(
			$this->Html->link(__('List', true), array('action' => 'index')),
			),
		),
	))); ?>