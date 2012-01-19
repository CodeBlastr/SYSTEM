<div class="privileges">
	<h1>List of Sync'd Plugins</h1>
    <p>This page will automatically refresh, until the sections available to the management of privileges are fully updated.</p>
    <p>This may take a few minutes.  Please wait until the process completes.</p>
    <ul>

<?php
foreach (CakeSession::read('Privileges.lastPlugin') as $text) :
	echo '<li>' . $text . '</li>';
endforeach;
?>
<?php
$last = end(CakeSession::read('Privileges.lastPlugin'));
if (CakeSession::read('Privileges.end') != $last) :  ?>
<script type="text/javascript">
$(document).ready(function() {
	var pathname = window.location.pathname;
	window.location.replace(pathname);
});
</script>
<?php else : ?>
	<li>FINISHED!!!!</li>
<?php endif; ?>

	</ul>
</div>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Actions',
		'items' => array(
			$this->Html->link(__('Run Aco Sync', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'aco_sync')),
			$this->Html->link(__('Clear Sync Session', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'clear_session')),
			$this->Html->link(__('Manage Privileges', true), array('plugin' => 'privileges', 'controller' => 'sections', 'action' => 'index')),
			)
		),
	)));
?>