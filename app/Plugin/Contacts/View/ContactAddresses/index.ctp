<div class="contactAddresses index">
	<h2><?php echo __('Contact Addresses');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('contact_address_type');?></th>
			<th><?php echo $this->Paginator->sort('street1');?></th>
			<th><?php echo $this->Paginator->sort('street2');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th><?php echo $this->Paginator->sort('zip_postal');?></th>
			<th><?php echo $this->Paginator->sort('country');?></th>
			<th><?php echo $this->Paginator->sort('primary');?></th>
			<th><?php echo $this->Paginator->sort('contact_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contactAddresses as $contactAddress):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $contactAddress['ContactAddress']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contactAddress['ContactAddressType']['name'], array('controller' => 'enumerations', 'action' => 'view', $contactAddress['ContactAddressType']['id'])); ?>
		</td>
		<td><?php echo $contactAddress['ContactAddress']['street1']; ?>&nbsp;</td>
		<td><?php echo $contactAddress['ContactAddress']['street2']; ?>&nbsp;</td>
		<td><?php echo $contactAddress['ContactAddress']['city']; ?>&nbsp;</td>
		<td><?php echo $contactAddress['ContactAddress']['state']; ?>&nbsp;</td>
		<td><?php echo $contactAddress['ContactAddress']['zip_postal']; ?>&nbsp;</td>
		<td><?php echo $contactAddress['ContactAddress']['country']; ?>&nbsp;</td>
		<td><?php echo $contactAddress['ContactAddress']['primary']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contactAddress['Contact']['name'], array('controller' => 'contacts', 'action' => 'view', $contactAddress['Contact']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $contactAddress['ContactAddress']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $contactAddress['ContactAddress']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $contactAddress['ContactAddress']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactAddress['ContactAddress']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Contact Address', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact Address Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
	</ul>
</div>