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
<?php 
if (!empty($upgradeDB)) {
?>

<div id="databaseUpgrades">
  <h2>Database Upgrade Needed</h2>
  <h6>The following database queries should run.</h6>
  <?php 
	echo $this->Form->create('Admin', array('url' => '/admin/')); 	
	$n = 0;
	foreach ($upgradeDB as $query) { 
	?>
  <p><?php echo $query; ?></p>
  <?php
		echo $this->Form->input('Query.'.$n.'.data', array('type' => 'hidden', 'value' => $query)); 
		$n++;
	}
	echo $this->Form->end('Run Upgrade Queries');
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
	echo $this->Form->create('Admin', array('url' => '/admin/')); 	
	$n = 0;
	foreach ($previousUpgrade as $query) { ?>
  <p><?php echo $query; ?></p>
  <?php }	?>
</div>
<?php 
}
?>
<!-- /homeheader -->
<div class="accordion">
  <ul>
    <li> <a href="#" title="Content"><span>Extend</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Settings', array('plugin' => null, 'controller' => 'settings', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Custom Forms', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Conditions', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Workflows', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index')); ?></li>
  </ul>
</div>
