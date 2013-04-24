<div class="privileges">
    <p class="alert alert-error"> IMPORTANT : This could take a long time, and cannot be interrupted.</p> 
    
   	<p class="alert alert-info"> For your information, these are your currently enabled plugin(s) : 
    <?php
    foreach (CakePlugin::loaded() as $plugin) { 
        echo $this->Html->link(__('%s ', $plugin), array('plugin' => Inflector::underscore(ZuhaInflector::pluginize($plugin)), 'controller' => ' ', 'action' => null)); 
    } ?>
    </p>
    
    <p><?php echo $this->Html->link(__('Click Here to Run Update ', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'aco_sync'), array('class' => 'btn btn-success'), 'Are you sure, you want to sync sections now?'); ?></p>
    
</div>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Actions',
		'items' => array(
			$this->Html->link(__('Manage Privileges', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index')),
			)
		),
	))); ?>
