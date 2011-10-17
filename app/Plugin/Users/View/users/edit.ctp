<div id="users-edit" class="users edit">
<?php 
	echo $form->create('User', array('enctype'=>'multipart/form-data')); 	
	echo $form->input('User.id');
	if (!empty($this->params['named']['cpw'])) {
		echo $form->input('User.username', array('type' => 'hidden'));
		echo $form->input('User.user_role_id', array('type' => 'hidden'));
		echo $form->input('User.password', array('value' => ''));
		echo $form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
	} else {
		?>
		<h3>User Profile Info </h3>
		<?php
		echo $this->element('snpsht', array('useGallery' => true, 'userId' => $this->data['User']['id'], 'thumbSize' => 'medium', 'thumbLink' => 'default')); 
		echo $form->input('User.first_name');
		echo $form->input('User.last_name');
		echo $form->input('User.username');
		echo $form->input('User.email');
		echo $form->input('User.user_role_id', array('type' => 'hidden'));
	}
	echo $form->end('Submit');
?>

<?php
	//if user paid role id defined and user's role id is paid role id then show the link Cancel Subscription 
	if(defined('__USERS_PAID_ROLE_ID') &&  __USERS_PAID_ROLE_ID == $this->data['User']['user_role_id'] ) {
	
		//if membership catalog item redirect defined then show the link Change Subscription
		if(defined('__APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT')) {
			echo $this->Html->link('Change Subscription' , __APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT);	
		}
		
		echo $this->Html->link('Cancel Subscription' , array('plugin' => 'members', 'controller' => 'members' , 
								'action' => 'cancelSubscription', $this->data['User']['id']));
	} 
?>

</div>

<?php 
// set the contextual menu items
$menu->setValue(array(array(
		'heading' => 'Users',
		'items' => array(
			$this->Html->link(__('View User', true), array('action' => 'view', $this->data['User']['id'])),
			$this->Html->link(__('Change Password', true), array($form->value('User.id'), 'cpw' => 1)),
			)
		),
));
?>