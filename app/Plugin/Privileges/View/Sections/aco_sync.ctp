<div class="privileges">
    <?php
	$last = end(CakeSession::read('Privileges.lastPlugin'));
	if (CakeSession::read('Privileges.end') != $last) {  ?>
        <p class="alert alert-error"> IMPORTANT : This page automatically refreshes, please wait until all sections are fully updated, and you see the message "Success!". (Updated Sections : 
        <?php
        foreach (CakeSession::read('Privileges.lastPlugin') as $text) {
            echo $text . ' ';
        } ?>)</p>
   
        <div class="progress progress-striped active">
            <?php $width = (count(CakeSession::read('Privileges.lastPlugin')) * 100) / count(CakePlugin::loaded()); ?>
            &nbsp; <?php echo $width; ?>% <div class="bar" style="width: <?php echo $width; ?>%;"></div>
        </div>

		<script type="text/javascript">
		$(document).ready(function() {
			var pathname = window.location.pathname;
			window.location.replace(pathname);
		});
       	</script>
	<?php } else { ?>
    	<p class="alert alert-success">Success! <?php
        foreach (CakeSession::read('Privileges.lastPlugin') as $text) {
            echo $text . ' ';
        } ?> updated.  <?php echo $this->Html->link(__('Manage Privileges Here'), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index')); ?></p>
	<?php } ?>
</div>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Actions',
		'items' => array(
			$this->Html->link(__('Start Again'), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'clear_session')),
			$this->Html->link(__('Manage Privileges'), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index')),
			)
		),
	))); ?>