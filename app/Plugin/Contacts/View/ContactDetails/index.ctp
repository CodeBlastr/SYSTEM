<div class="contactDetails index">
	<h2><?php echo __('Contact Details');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('contact_detail_type_id');?></th>
			<th><?php echo $this->Paginator->sort('value');?></th>
			<th><?php echo $this->Paginator->sort('primary');?></th>
			<th><?php echo $this->Paginator->sort('contact_id');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contactDetails as $contactDetail):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $contactDetail['ContactDetail']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contactDetail['ContactDetailType']['name'], array('controller' => 'enumerations', 'action' => 'view', $contactDetail['ContactDetailType']['id'])); ?>
		</td>
		<td><?php echo $contactDetail['ContactDetail']['value']; ?>&nbsp;</td>
		<td><?php echo $contactDetail['ContactDetail']['primary']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contactDetail['Contact']['name'], array('controller' => 'contacts', 'action' => 'view', $contactDetail['Contact']['id'])); ?>
		</td>
		<td><?php echo $contactDetail['ContactDetail']['creator_id']; ?>&nbsp;</td>
		<td><?php echo $contactDetail['ContactDetail']['modifier_id']; ?>&nbsp;</td>
		<td><?php echo $contactDetail['ContactDetail']['created']; ?>&nbsp;</td>
		<td><?php echo $contactDetail['ContactDetail']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $contactDetail['ContactDetail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $contactDetail['ContactDetail']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $contactDetail['ContactDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactDetail['ContactDetail']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Contact Detail', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact Detail Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
	</ul>
</div>