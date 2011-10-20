<div class="banners view">
<h2><?php  __('Banner');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Banner Position'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($banner['BannerPosition']['name'], array('controller' => 'banner_positions', 'action' => 'view', $banner['BannerPosition']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Schedule Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['schedule_start_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Schedule End Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['schedule_end_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Gender'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['gender']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Age Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['age_group']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['price']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Customer'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($banner['Customer']['username'], array('controller' => 'customers', 'action' => 'view', $banner['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Redumption Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['redemption_url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Discount Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['discount_price']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Discount Percentage'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['discount_percentage']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Is Published'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['is_published']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Creator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($banner['Creator']['username'], array('controller' => 'creators', 'action' => 'view', $banner['Creator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modifier'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($banner['Modifier']['username'], array('controller' => 'modifiers', 'action' => 'view', $banner['Modifier']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $banner['Banner']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banner', true), array('action' => 'edit', $banner['Banner']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Banner', true), array('action' => 'delete', $banner['Banner']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $banner['Banner']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Banners', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Banner Positions', true), array('controller' => 'banner_positions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner Position', true), array('controller' => 'banner_positions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers', true), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer', true), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Creators', true), array('controller' => 'creators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator', true), array('controller' => 'creators', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Modifiers', true), array('controller' => 'modifiers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Modifier', true), array('controller' => 'modifiers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Items', true), array('controller' => 'order_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item', true), array('controller' => 'order_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php echo __('Related Order Items');?></h3>
	<?php if (!empty($banner['OrderItem'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['name'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Catalog Item Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['catalog_item_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Order Payment Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['order_payment_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Order Shipment Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['order_shipment_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Order Transaction Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['order_transaction_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Quantity');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['quantity'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Price');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['price'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Weight');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['weight'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Height');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['height'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Width');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['width'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Length');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['length'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['status'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Foreign Key');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['foreign_key'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Model');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['model'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Is Virtual');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['is_virtual'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Customer Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['customer_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Contact Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['contact_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Assignee Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['assignee_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Creator Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['creator_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modifier Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['modifier_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $banner['OrderItem']['modified'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Order Item', true), array('controller' => 'order_items', 'action' => 'edit', $banner['OrderItem']['id'])); ?></li>
			</ul>
		</div>
	</div>
	