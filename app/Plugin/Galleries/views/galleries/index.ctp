<?php echo $this->Element('scaffolds/index', array('data' => $galleries)); ?>
<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('New Gallery', true), array('action' => 'edit')),
			)
		),
	)
);
?>