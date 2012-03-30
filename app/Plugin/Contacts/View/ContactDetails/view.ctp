<div class="contactDetails view">
<h2><?php  __('Contact Detail');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactDetail['ContactDetail']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Contact Detail Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contactDetail['ContactDetail']['contact_detail_type'], array('controller' => 'enumerations', 'action' => 'view', $contactDetail['ContactDetail']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactDetail['ContactDetail']['value']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Primary'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactDetail['ContactDetail']['primary']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Contact'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contactDetail['Contact']['name'], array('controller' => 'contacts', 'action' => 'view', $contactDetail['Contact']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Creator Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactDetail['ContactDetail']['creator_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modifier Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactDetail['ContactDetail']['modifier_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactDetail['ContactDetail']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contactDetail['ContactDetail']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contact Detail', true), array('action' => 'edit', $contactDetail['ContactDetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Contact Detail', true), array('action' => 'delete', $contactDetail['ContactDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactDetail['ContactDetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contact Details', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact Detail', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact Detail Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
	</ul>
</div>
