<div id="users-edit" class="users edit">
<?php 
	echo $this->Form->create('User', array('enctype'=>'multipart/form-data')); 	?>
    
  <fieldset>
    <legend><h2><?php echo __('Edit User Profile'); ?></h2></legend>
	<?php 
	echo $this->Form->input('User.id');
	if (!empty($this->request->params['named']['cpw'])) {
		echo $this->Form->input('User.username', array('type' => 'hidden'));
		echo $this->Form->input('User.user_role_id', array('type' => 'hidden'));
		echo $this->Form->input('User.password', array('value' => ''));
		echo $this->Form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
	} else {
		echo $this->element('snpsht', array('useGallery' => true, 'userId' => $this->request->data['User']['id'], 'thumbSize' => 'medium', 'thumbLink' => 'default')); 
		echo $this->Form->input('User.first_name');
		echo $this->Form->input('User.last_name');
		echo $this->Form->input('User.username');
		echo $this->Form->input('User.email');
		echo $this->Form->input('User.user_role_id', array('type' => 'hidden'));
	}
	echo $this->Form->end('Submit');
?>
</fieldset>

<?php
	//if user paid role id defined and user's role id is paid role id then show the link Cancel Subscription 
	if(defined('__USERS_PAID_ROLE_ID') &&  __USERS_PAID_ROLE_ID == $this->request->data['User']['user_role_id'] ) {
	
		//if membership catalog item redirect defined then show the link Change Subscription
		if(defined('__APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT')) {
			echo $this->Html->link('Change Subscription' , __APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT);	
		}
		
		echo $this->Html->link('Cancel Subscription' , array('plugin' => 'members', 'controller' => 'members' , 
								'action' => 'cancelSubscription', $this->request->data['User']['id']));
	} 
?>

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
	)));
?>