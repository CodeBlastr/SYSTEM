<div class="countries view">
<h2><?php  __('Country');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Country', true), array('action' => 'edit', $country['Country']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Country', true), array('action' => 'delete', $country['Country']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $country['Country']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Countries', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Country', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Addresses', true), array('controller' => 'contact_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact Address', true), array('controller' => 'contact_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List States', true), array('controller' => 'states', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New State', true), array('controller' => 'states', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Contact Addresses');?></h3>
	<?php if (!empty($country['ContactAddress'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Contact Address Type Id'); ?></th>
		<th><?php __('Street1'); ?></th>
		<th><?php __('Street2'); ?></th>
		<th><?php __('City'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('Zip Postal'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('Primary'); ?></th>
		<th><?php __('Contact Id'); ?></th>
		<th><?php __('Creator Id'); ?></th>
		<th><?php __('Modifier Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($country['ContactAddress'] as $contactAddress):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $contactAddress['id'];?></td>
			<td><?php echo $contactAddress['contact_address_type_id'];?></td>
			<td><?php echo $contactAddress['street1'];?></td>
			<td><?php echo $contactAddress['street2'];?></td>
			<td><?php echo $contactAddress['city'];?></td>
			<td><?php echo $contactAddress['state_id'];?></td>
			<td><?php echo $contactAddress['zip_postal'];?></td>
			<td><?php echo $contactAddress['country_id'];?></td>
			<td><?php echo $contactAddress['primary'];?></td>
			<td><?php echo $contactAddress['contact_id'];?></td>
			<td><?php echo $contactAddress['creator_id'];?></td>
			<td><?php echo $contactAddress['modifier_id'];?></td>
			<td><?php echo $contactAddress['created'];?></td>
			<td><?php echo $contactAddress['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'contact_addresses', 'action' => 'view', $contactAddress['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'contact_addresses', 'action' => 'edit', $contactAddress['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'contact_addresses', 'action' => 'delete', $contactAddress['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactAddress['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Contact Address', true), array('controller' => 'contact_addresses', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related States');?></h3>
	<?php if (!empty($country['State'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($country['State'] as $state):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $state['id'];?></td>
			<td><?php echo $state['name'];?></td>
			<td><?php echo $state['country_id'];?></td>
			<td><?php echo $state['created'];?></td>
			<td><?php echo $state['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'states', 'action' => 'view', $state['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'states', 'action' => 'edit', $state['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'states', 'action' => 'delete', $state['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $state['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New State', true), array('controller' => 'states', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
