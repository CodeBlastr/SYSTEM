<?php
/**
 * Admin Dashboard Index View
 *
 * This view is the hub for the admin section of the site. Will be used as the launchpad for site administration.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.views.admin
 * @since         Zuha(tm) v 0.0009
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>

something and then... <?php echo $myVar; ?> ... should be between the dots.
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

if (!empty($previousUpgrade)) {
?>
<div id="databaseUpgrades">
  <h2>Upgrade Queries Ran</h2>
  <h6>The following database queries we're just ran.</h6>
  <?php 
	echo $form->create('Admin', array('url' => '/admin/')); 	
	$n = 0;
	foreach ($previousUpgrade as $query) { ?>
  <p><?php echo $query; ?></p>
  <?php }	?>
</div>
<?php 
}
?>
<div class="pointer"></div>
<div class="sub">
  <div class="menu">
    <ul>
      <li class="title">Permissions</li>
      <li><a href="/admin/permissions/acores">Permissions</a></li>
    </ul>
    <ul>
      <li class="title">Settings</li>
      <li><a href="/admin/settings">System Settings</a></li>
    </ul>
    <ul>
      <li class="title">Reports</li>
      <li><a href="/admin/reports">Analytics</a></li>
      <li><a href="/admin/reports">Reports</a></li>
    </ul>
    <p class="otherFeatures"><a href="/" title="Public Site">Public Site</a></p>
  </div>
</div>
<a href="#" id="helpOpen">Turn Help Text On</a>