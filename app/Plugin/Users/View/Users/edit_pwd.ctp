<div id="users-edit" class="users edit form">    
  	<fieldset>
    <?php
    echo __('<legend><h2>Change Password</h2></legend>', $editLink);
	echo $this->Form->create('User', array('enctype'=>'multipart/form-data'));
    echo $this->Form->input('User.id');
	echo $this->Form->input('User.pwd_change', array('type' => 'hidden', 'value' => 0));
	echo $this->Form->input('User.password', array('value' => ''));
	echo $this->Form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
    echo $this->Form->end('Submit');
    ?>
	</fieldset>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('View User', true), array('action' => 'view', $this->request->data['User']['id'])),
			$this->Html->link(__('Change Picture', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'edit', 'User',  $this->request->data['User']['id'])),
			$this->Html->link(__('Change Password', true), array($this->request->data['User']['id'], 'cpw' => 1)),
			)
		),
	))); ?>