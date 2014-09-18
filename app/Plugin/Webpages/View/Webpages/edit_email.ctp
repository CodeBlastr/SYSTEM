<div class="clearfix">
	<?php echo $this->Form->create('Webpage', array('type' => 'file')); ?>
	<div class="clearfix">
		<div class="webpages form col-md-9">
			<fieldset>
				<?php
				echo $this->Form->input('Webpage.id');
				echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'value' => 'email'));
				echo $this->Form->input('Webpage.name', array('label' => 'Template Name'));
				echo $this->Form->input('Webpage.title', array('label' => 'Subject'));
				echo $this->Form->input('Webpage.content', array('type' => 'richtext', 'label' => 'Body'));
				?>
			</fieldset>
		</div>
		<div class="col-md-3" id="webpages-sidebar">
			<div class="panel">
			</div>
		</div>
	</div>
	<?php echo $this->Form->submit('Save Changes'); ?>
	<?php echo $this->Form->end(); ?>
</div>

<?php
$menuItems = array(
	$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index', 'email')),
	$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add', 'email'), array('title' => 'Add Email Template')),
	$this->Html->link(__('View'), array('controller' => 'webpages', 'action' => 'view', $this->request->data['Webpage']['id'])),
	$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Webpage.id')), null, sprintf(__('Are you sure you want to delete %s?'), $this->Form->value('Webpage.name'))),
);

$this->set('context_menu', array('menus' => array(
		array('heading' => 'Webpages',
			'items' => $menuItems
		)
)));
