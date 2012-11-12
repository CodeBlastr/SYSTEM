<?php $this->set('title_for_layout', $webpage['Webpage']['title']); ?>
<?php echo $this->Html->meta('keywords', $webpage['Webpage']['keywords'], array('inline' => false)); ?>
<?php echo $this->Html->meta('description', $webpage['Webpage']['description'], array('inline' => false)); ?>  

<?php echo $webpage['Webpage']['content'];  



/*
<div id="post-comments">
	<?php /* $this->CommentWidget->options(array('allowAnonymousComment' => false));?>
	<?php // echo $this->CommentWidget->display();?>
</div> */ ?>

<?php 
// set the contextual menu items      
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'webpages', 'action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add'), array('class' => 'add')),
			$this->Html->link(__('Edit'), array('controller' => 'webpages', 'action' => 'edit', $webpage['Webpage']['id']), array('class' => 'edit')),
			$this->Html->link(__('Delete'), array('controller' => 'webpages', 'action' => 'delete', $webpage['Webpage']['id']), array(), 'Are you sure you want to delete "'.strip_tags($webpage['Webpage']['title']).'"'),
			)
		),
	))); ?>