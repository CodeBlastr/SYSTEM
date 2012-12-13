<div id="users-edit" class="users edit form">    
  <fieldset>
    <?php
    $editLink = empty($this->request->params['named']['cpw']) ? $this->Html->link('Change Password', array('action' => 'edit', $this->request->data['User']['id'], 'cpw' => 1), array('class' => 'btn')) : $this->Html->link('Change Details', array('action' => 'edit', $this->request->data['User']['id']), array('class' => 'btn'));
    echo __('<legend><h2>Edit User Profile %s</h2></legend>', $editLink);

	if (!empty($this->request->params['named']['cpw'])) {
        // change password form
        echo $this->Form->create('User', array('enctype'=>'multipart/form-data'));
        echo $this->Form->input('User.id');
		echo $this->Form->input('User.username', array('type' => 'hidden'));
		echo $this->Form->input('User.user_role_id', array('type' => 'hidden'));
		echo $this->Form->input('User.password', array('value' => ''));
		echo $this->Form->input('User.confirm_password', array('value' => '', 'type' => 'password'));
        echo $this->Form->end('Submit');
	} else {
        // edit user avatar form
        echo '<div id="userEditThumb">';
        echo $this->Element('thumb', array('thumbLink' => '', 'thumbLinkOptions' => array('style' => 'color: #333;font-size: 10px;'), 'model' => 'User', 'foreignKey' => $this->request->data['User']['id']), array('plugin' => 'galleries'));
        echo $this->Html->link('Change Photo', '/', array('id' => 'userEditThumbLink', 'class' => 'toggleClick', 'data-target' => '#GalleryEditForm')); 
        echo '</div>';

        echo $this->Form->create('Gallery', array('url' => '/galleries/galleries/mythumb', 'enctype' => 'multipart/form-data'));
        echo $this->Form->input('GalleryImage.is_thumb', array('type' => 'hidden', 'value' => 1));
        echo $this->Form->input('GalleryImage.filename', array('label' => 'Choose image', 'type' => 'file'));
	    echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => 'User'));
    	echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $this->request->data['User']['id']));
    	echo $this->Form->end('Upload'); 

        
        // edit user form
        echo $this->Form->create('User', array('enctype'=>'multipart/form-data'));
        echo $this->Form->input('User.id');
        echo $this->Form->input('User.first_name');
		echo $this->Form->input('User.last_name');
		echo $this->Form->input('User.username');
		echo $this->Form->input('User.email');
    	echo $this->Form->input('User.user_role_id', array('type' => 'hidden'));
        echo $this->Form->end('Submit');
	}
?>
</fieldset>

<?php 
	//if user paid role id defined and user's role id is paid role id then show the link Cancel Subscription 
	if(defined('__USERS_PAID_ROLE_ID') &&  __USERS_PAID_ROLE_ID == $this->request->data['User']['user_role_id'] ) {
	
		//if membership catalog item redirect defined then show the link Change Subscription
		if(defined('__APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT')) {
			echo $this->Html->link('Change Subscription' , __APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT);	
		}
		echo $this->Html->link('Cancel Subscription' , array('plugin' => 'members', 'controller' => 'members', 'action' => 'cancelSubscription', $this->request->data['User']['id']));
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
	))); ?>