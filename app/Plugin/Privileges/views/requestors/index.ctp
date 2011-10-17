<div class="requestors index">
<h2><?php __('Requestors');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('model');?></th>
	<th><?php echo $this->Paginator->sort('foreign_key');?></th>
	<th><?php echo $this->Paginator->sort('alias');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($requestors as $requestor):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $requestor['Requestor']['id']; ?>
		</td>
		<td>
			<?php echo $requestor['Requestor']['parent_id']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($requestor['Requestor']['model'], array('plugin' => 'users', 'controller' => Inflector::tableize($requestor['Requestor']['model']), 'action' => 'view', $requestor['Requestor']['foreign_key'])); ?>
		</td>
		<td>
			<?php echo $requestor['Requestor']['foreign_key']; ?>
		</td>
		<td>
			<?php echo $requestor['Requestor']['alias']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $requestor['Requestor']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $requestor['Requestor']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $requestor['Requestor']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->element('paging'); ?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Requestor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Acos', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Aco', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
	</ul>
</div>
