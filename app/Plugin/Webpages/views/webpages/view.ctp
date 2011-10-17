<?php $this->set('title_for_layout', $webpage['Webpage']['title']); ?>
<?php echo $this->Html->meta('keywords', $webpage['Webpage']['keywords'], array('inline' => false)); ?>
<?php echo $this->Html->meta('description', $webpage['Webpage']['description'], array('inline' => false)); ?>

<?php echo $webpage['Webpage']['content'];  



/*
<div id="post-comments">
	<?php /* $commentWidget->options(array('allowAnonymousComment' => false));?>
	<?php // echo $commentWidget->display();?>
</div> */ ?>



<?php
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Html->link(__('List', true), array('controller' => 'webpages', 'action' => 'index')),
			$this->Html->link(__('New', true), array('controller' => 'webpages', 'action' => 'add')),
			$this->Html->link(__('Edit', true), array('controller' => 'webpages', 'action' => 'edit', $webpage['Webpage']['id'])),
			)
		),
	)
); 
?>