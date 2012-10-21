<div class="webpages form">
	<?php echo $this->Form->create('Webpage');?>
    <fieldset>
    	<?php
        echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'default' => 'template'));
		echo $this->Form->input('Webpage.name', array('label' => 'Internal Template Name'));
		echo $this->Form->input('Webpage.content', array('type' => 'richtext')); ?>
	</fieldset>
    
    <fieldset>
        <legend><?php echo __('Template Settings'); ?></legend>
    	<?php
		echo $this->Form->input('is_default', array('type' => 'checkbox'));
		echo $this->Form->input('template_urls', array('after' => ' <br>One url per line. (ex. /tickets/tickets/view/*)'));
		echo $this->Form->input('user_roles', array('type' => 'select', 'options' => $userRoles, 'multiple' => 'checkbox')); ?>
    </fieldset>
    
	<?php echo $this->Form->end('Save Webpage');?>
</div>
<?php
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			 $this->Html->link(__('List', true), array('action' => 'index', 'template')),									 
			 )
		)
	))); ?>