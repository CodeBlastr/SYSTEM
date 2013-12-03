<div id="users-edit" class="users edit form">    
  <fieldset>
    <?php $editLink = empty($this->request->params['named']['cpw']) ? $this->Html->link('Change Password', array('action' => 'edit', $this->request->data['User']['id'], 'password'), array('class' => 'btn')) : $this->Html->link('Change Details', array('action' => 'edit', $this->request->data['User']['id']), array('class' => 'btn')); ?>
    <?php echo __('<legend><h2>Edit User Profile %s</h2></legend>', $editLink); ?>
	<?php echo '<div id="userEditThumb">'; ?>
    <?php echo $this->Element('thumb', array('thumbLink' => '', 'thumbLinkOptions' => array('style' => 'color: #333;font-size: 10px;'), 'model' => 'User', 'foreignKey' => $this->request->data['User']['id']), array('plugin' => 'galleries')); ?>
	<?php echo $this->Html->link('Change Photo', '/', array('id' => 'userEditThumbLink', 'class' => 'toggleClick', 'data-target' => '#GalleryEditForm')); ?>
	<?php echo '</div>'; ?>
	<?php echo $this->Form->create('Gallery', array('url' => '/galleries/galleries/mythumb', 'enctype' => 'multipart/form-data')); ?>
	<?php echo $this->Form->input('GalleryImage.is_thumb', array('type' => 'hidden', 'value' => 1)); ?>
	<?php echo $this->Form->input('GalleryImage.filename', array('label' => 'Choose image', 'type' => 'file')); ?>
	<?php echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => 'User')); ?>
	<?php echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $this->request->data['User']['id'])); ?>
	<?php echo $this->Form->end('Upload'); ?>

	<?php echo $this->Form->create('User', array('enctype'=>'multipart/form-data')); ?>
	<?php echo $this->Form->input('User.id'); ?>
	<?php echo $this->Form->input('User.first_name'); ?>
	<?php echo $this->Form->input('User.last_name'); ?>
	<?php echo $this->Form->input('User.username'); ?>
	<?php echo $this->Form->input('User.email'); ?>
	<?php echo $this->Form->input('User.user_role_id', array('type' => 'hidden')); ?>
	<?php echo $this->Form->end('Submit'); ?>
</fieldset>

<?php // if user paid role id defined and user's role id is paid role id then show the link Cancel Subscription  ?>
<?php if(defined('__USERS_PAID_ROLE_ID') &&  __USERS_PAID_ROLE_ID == $this->request->data['User']['user_role_id'] ) : ?>
	<?php //if membership catalog item redirect defined then show the link Change Subscription ?>
	<?php if(defined('__APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT')) : ?>
		<?php echo $this->Html->link('Change Subscription' , __APP_MEMBERSHIP_CATALOG_ITEM_REDIRECT); ?>
	<?php endif; ?>
	<?php echo $this->Html->link('Cancel Subscription' , array('plugin' => 'members', 'controller' => 'members', 'action' => 'cancelSubscription', $this->request->data['User']['id'])); ?>
<?php endif; ?>

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
		)
	)));