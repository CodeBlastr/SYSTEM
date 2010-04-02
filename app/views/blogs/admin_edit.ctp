<div class="blogs form">
<?php echo $form->create('Blog');?>
	<fieldset>
 		<legend><?php __('Edit Blog');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('title');
		echo $form->input('start_page');
		echo $form->input('public');
		echo $form->input('user_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Blog.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Blog.id'))); ?></li>
		<li><?php echo $html->link(__('List Blogs', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Blog Posts', true), array('controller' => 'blog_posts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Blog Post', true), array('controller' => 'blog_posts', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Blog User Groups', true), array('controller' => 'blog_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Blog User Group', true), array('controller' => 'blog_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
