<div class="webapges index">
	<h2><?php echo __('Webpages');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('id');?></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('Alias.name');?></th>
		<th><?php echo $this->Paginator->sort('created');?></th>
		<th><?php echo $this->Paginator->sort('modified');?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($webpages as $webpage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $webpage['Webpage']['id']; ?>
		</td>
		<td>
			<?php echo $webpage['Webpage']['name']; ?>
		</td>
		<td>
			<?php echo $webpage['Alias']['name']; ?>
		</td>
		<td>
			<?php echo $webpage['Webpage']['created']; ?>
		</td>
		<td>
			<?php echo $webpage['Webpage']['modified']; ?>
		</td>
		<td class="actions">
			<?php 
			if (!empty($webpage['Alias']['name'])) {
				echo $this->Html->link(__('View', true), array('admin' => false, 'plugin' => null, 'controller' => $webpage['Alias']['name']));  } else {
				echo $this->Html->link(__('View', true), array('admin' => false, 'action' => 'view', $webpage['Webpage']['id']));
			}
			?>

			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $webpage['Webpage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $webpage['Webpage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $webpage['Webpage']['id'])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
</div>
<?php echo $this->Element('paging'); ?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			$this->Paginator->sort('name'),
			$this->Html->link(__('Add'), array('controller' => 'webpages', 'action' => 'add'), array('class' => 'add')),
			)
		),
	)));
?>