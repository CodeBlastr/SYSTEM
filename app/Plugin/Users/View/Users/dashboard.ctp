<div class="users dashboard row">
	<div class="col-md-8">
		<h3>Last 5 Users</h3>
		<div class="list-group">
		<?php foreach ($users as $user) : ?>
			<div class="list-group-item">
				<?php echo $this->Html->link($user['User']['full_name'], array('action' => 'view', $user['User']['id'])); ?>
				<span class="badge">Since : <?php echo ZuhaInflector::datify($user['User']['created']); ?></span>
				<span class="badge"><?php echo $user['UserRole']['name']; ?></span>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	
	<div class="col-md-4">
		<h3>Quick Links</h3>
		<div class="list-group">
			<?php echo $this->Html->link('Add User', array('action' => 'procreate'), array('class' => 'list-group-item')); ?>
			<?php echo $this->Html->link('Manage User Roles', array('controller' => 'user_roles', 'action' => 'index'), array('class' => 'list-group-item')); ?>
		</div>
	</div>
</div>
