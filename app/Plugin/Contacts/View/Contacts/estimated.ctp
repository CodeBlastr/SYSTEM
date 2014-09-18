
<div class="row">
	<div class="col-md-4">
		<div class="well">
			<?php echo $this->Html->markdown(nl2br($estimate['Estimate']['introduction'])); ?>
		</div>
	</div>
	<div class="col-md-8">
		<?php echo $estimate['Estimate']['description']; ?>
	</div>
</div>
<?php //debug($estimate); ?>

<?php 
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Dashboard'), array('action' => 'dashboard')),
	$this->Html->link($estimate['Contact']['name'], array('action' => 'view', $estimate['Contact']['id'])),
	__('Proposal')
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Client View'), array('action' => 'proposal', $estimate['Estimate']['id'])),
			$this->Html->link(__('Edit'), array('action' => 'estimate', $estimate['Contact']['id'], $estimate['Estimate']['id'])),
			)
		),
	)));