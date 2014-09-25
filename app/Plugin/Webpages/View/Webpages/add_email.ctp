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
			<strong>Example content</strong>
			<p>
				You can mix static and dynamic content by using special delimeters 
				in your text. For example you might have a product email, and need
				to use the *| Product.name |*.   In which case that piece of 
				text would be replaced with the actual Product name.  Maybe you need
				the to say, thank you  *| User.full_name |* too. Well that's how it's done.
			</p>
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
