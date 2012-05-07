<?php
/**
 * Admin Dashboard Index View
 *
 * This view is the hub for the admin section of the site. Will be used as the launchpad for site administration.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.views.admin
 * @since         Zuha(tm) v 0.0009
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>
<?php if (!empty($upgradeDb) && is_array($upgradeDb)) { ?>

<div id="databaseUpgrades">
	<?php echo $this->Form->create(''); ?>
	<fieldset>
    	<legend class="toggleClick">Database Upgrade Needed</legend>
			<div style="padding: 2em;">
        <?php
		foreach ($upgradeDb as $value) {
			echo __('On table <strong>%s</strong> the follow updates will run : <br />', $value['table']);
			echo '<pre>' . $value['queries'] . '</pre>'; 
		} ?>
        </div>
        <?php
		echo $this->Form->hidden('Upgrade.confirmed', array('value' => true));
        echo $this->Form->submit('Run Upgrade(s)'); ?>
    </fieldset>
	<?php echo $this->Form->end(); ?>
</div>

<?php } ?>

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
