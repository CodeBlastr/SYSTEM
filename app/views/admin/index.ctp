something and then...

<?php echo $myVar; ?>

... should be between the dots.


<?php 
if (!empty($upgradeDB)) {
?>
<div id="databaseUpgrades">
	<h2>Database Upgrade Needed</h2>
    <h6>The following database queries should run.</h6>
	<?php 
	echo $form->create('Admin', array('url' => '/admin/')); 	
	$n = 0;
	foreach ($upgradeDB as $query) { 
	?>
	    <p><?php echo $query; ?></p>
    <?php
		echo $form->input('Query.'.$n.'.data', array('type' => 'hidden', 'value' => $query)); 
		$n++;
	}
	echo $form->end('Run Upgrade Queries');
	?>
</div>
<?php 
}
?>