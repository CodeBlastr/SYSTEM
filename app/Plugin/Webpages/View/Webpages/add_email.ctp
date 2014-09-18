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
	<?php echo $this->Form->submit('Save'); ?>
	<?php echo $this->Form->end(); ?>
</div>

<?php
$menuItems = array(
	$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index', 'email')),
);

$this->set('context_menu', array('menus' => array(
		array('heading' => 'Webpages',
			'items' => $menuItems
		)
)));
