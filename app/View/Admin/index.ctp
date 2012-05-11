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
 
if (empty($runUpdates)) { ?>

    <div class="accordion">
      <ul>
        <li> <a href="#" title="Content"><span>Admin</span></a>
      </ul>
      <ul>
        <li><?php echo $this->Html->link('Privileges', array('plugin' => 'privileges', 'controller' => 'privileges', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Settings', array('plugin' => null, 'controller' => 'settings', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Custom Forms', array('plugin' => 'forms', 'controller' => 'forms', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Conditions', array('plugin' => null, 'controller' => 'conditions', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Workflows', array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'index')); ?></li>
      </ul>
      <ul>
        <li> <a href="#" title="Content"><span>Updates</span></a>
      </ul>
      <ul>
        <li>
          <?php 
            echo $this->Form->create('', array('id' => 'updateForm')); 
            echo $this->Form->hidden('Upgrade.all', array('value' => true));
            echo $this->Form->submit('Check for Updates');
            echo $this->Form->end(); ?>
        </li>
      </ul>
    </div>


<?php
} else { ?>

	<div id="databaseUpgrades">
   	  <?php 
       $complete = CakeSession::read('Updates.complete');
       echo $this->Form->create('', array('id' => 'autoUpdateForm')); 
       echo $this->Form->hidden('Upgrade.all', array('value' => true));
       //echo $this->Form->submit('Check for Updates');
       echo $this->Form->end(); ?>
	  <ul>
	    <?php
		if (CakeSession::read('Updates.last')) {
			foreach (CakeSession::read('Updates.last') as $table => $action) {
				echo __('<li>Table %s is %s</li>', $table, $action);
			}
		}?>
	  </ul>
	</div>

	<?php
    $complete = CakeSession::read('Updates.complete');
    if (CakeSession::read('Updates') && empty($complete)) {  ?>
		<script type="text/javascript">
        $(function() {
            //var pathname = window.location.pathname;
            //window.location.replace(pathname);
           // alert('lets refresh');
		   $("#autoUpdateForm").submit();
        });
        </script>
<?php 
    } 
} ?>
