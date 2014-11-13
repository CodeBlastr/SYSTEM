<div class="privileges row">
	<?php $last = end(CakeSession::read('Privileges.lastPlugin')); ?>
	<?php if (CakeSession::read('Privileges.end') != $last) : ?>
		<div class="alert alert-warning">
			<strong>IMPORTANT : </strong>This page automatically refreshes, please wait until all sections are fully updated, and you see the message "Success!".
		</div>
		<div class="progress progress-striped active">
			<?php $width = (count(CakeSession::read('Privileges.lastPlugin')) * 100) / count(CakePlugin::loaded()); ?>
			&nbsp; <?php echo number_format($width, 0); ?>% 
			<div class="progress-bar progress-bar-success bar" style="width: <?php echo number_format($width, 0); ?>%;"></div>
		</div>
		<?php foreach (CakePlugin::loaded() as $plugin) : ?>
			<?php if (in_array($plugin, CakeSession::read('Privileges.lastPlugin'))) : ?>
				<span class="label label-success"><?php echo $plugin; ?></span>
			<?php else : ?>
				<span class="label label-default"><?php echo $plugin; ?></span>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="alert alert-success">
			<h2>
				<b>Success!</b> <?php echo $this->Html->link(__('Manage Privileges Here'), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index'), array('class' => 'btn btn-success')); ?>
			</h2>
		</div>
		<div class="col-md-12">
			<p>
				The following plugins were updated:<br />
				<?php foreach (CakeSession::read('Privileges.lastPlugin') as $plugin) : ?>
					<span class="label label-success"><?php echo $plugin; ?></span>
				<?php endforeach; ?>
			</p>
		</div>
	<?php endif; ?>
</div>

<?php if (CakeSession::read('Privileges.end') != $last) : ?>
	<script type="text/javascript">
		$(document).ready(function() {
			var pathname = window.location.pathname;
			window.location.replace(pathname);
		}); 
	</script>
<?php endif; ?>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array( array(
			'heading' => 'Actions',
			'items' => array(
				$this->Html->link(__('Start Again'), array(
					'plugin' => 'privileges',
					'controller' => 'sections',
					'action' => 'clear_session'
				)),
				$this->Html->link(__('Manage Privileges'), array(
					'plugin' => 'privileges',
					'controller' => 'sections',
					'action' => 'index'
				)),
				$this->Html->link(__('Manage Privileges'), array(
					'plugin' => 'privileges',
					'controller' => 'sections',
					'action' => 'index'
				)),
			)
		))));
