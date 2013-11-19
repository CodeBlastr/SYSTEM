<div class="userRoles form row">

	<div class="col-md-5">
		<p class="alert alert-info">
			User roles allow you to group users for the purpose of granting permissions for many users at once.
		</p>
		<?php if (!empty($this->request->data['UserRole']['duplicate'])) : ?>
			<p class="span4 pull-right well">
				Duplicating user roles carries permissions from the old user role to the new user role.
			</p>
		<?php endif; ?>
	</div>
	<div class="col-md-7">
		<?php echo $this->Form->create('UserRole'); ?>
		<fieldset>
			<?php echo $this->Form->input('UserRole.name'); ?>
			<?php echo $this->Form->input('UserRole.is_registerable'); ?>
			<?php echo $this->Form->input('UserRole.duplicate', array('type' => 'hidden')); ?>
			<?php echo $this->Form->input('UserRole.view_prefix', array('empty' => '-- Optional View Access --')); ?>
		</fieldset>
		<?php echo $this->Form->end('Submit'); ?>
	</div>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
		array(
			'heading' => 'User Roles',
			'items' => array($this->Html->link(__('List', true), array('action' => 'index')), )
		),
		array(
			'heading' => 'Users',
			'items' => array($this->Html->link(__('Users', true), array(
					'controller' => 'users',
					'action' => 'index'
				)), )
		),
	)));
