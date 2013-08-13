<div class="privileges">
    <?php
	$last = end(CakeSession::read('Privileges.lastPlugin'));
	if (CakeSession::read('Privileges.end') != $last) {  ?>
        <p class="alert alert-error"><strong>IMPORTANT : </strong>This page automatically refreshes, please wait until all sections are fully updated, and you see the message "Success!".</p>
   
        <div class="progress progress-striped active">
            <?php $width = (count(CakeSession::read('Privileges.lastPlugin')) * 100) / count(CakePlugin::loaded()); ?>
            &nbsp; <?php echo number_format($width, 0); ?>% <div class="bar" style="width: <?php echo number_format($width, 0); ?>%;"></div>
        </div>

		<?php
        foreach (CakePlugin::loaded() as $plugin) {
			if ( in_array($plugin, CakeSession::read('Privileges.lastPlugin'))) {
				echo '<span class="label label-success">',$plugin,'</span> ';
			} else {
				echo '<span class="label">',$plugin,'</span> ';
			}
		}
		?>

		<script type="text/javascript">
		$(document).ready(function() {
			var pathname = window.location.pathname;
			window.location.replace(pathname);
		});
       	</script>
	<?php } else { ?>
    	<p class="alert alert-success"><b>Success!</b>
			<br />
			The following plugins were updated:<br />
			<?php
			foreach (CakeSession::read('Privileges.lastPlugin') as $plugin) {
				echo '<span class="label label-success">',$plugin,'</span> ';
			}
			?>
			<br />
			<?php echo $this->Html->link(__('Manage Privileges Here'), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index'), array('class' => 'btn btn-success')); ?>
		</p>
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