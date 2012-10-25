<div class="eventsGuests view">
<h2><?php  echo __('Events Guest');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($eventsGuest['EventsGuest']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eventsGuest['Event']['name'], array('controller' => 'events', 'action' => 'view', $eventsGuest['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eventsGuest['User']['full_name'], array('controller' => 'users', 'action' => 'view', $eventsGuest['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($eventsGuest['EventsGuest']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event Venue'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eventsGuest['EventVenue']['name'], array('controller' => 'event_venues', 'action' => 'view', $eventsGuest['EventVenue']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event Seat'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eventsGuest['EventSeat']['name'], array('controller' => 'event_seats', 'action' => 'view', $eventsGuest['EventSeat']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creator Id'); ?></dt>
		<dd>
			<?php echo h($eventsGuest['EventsGuest']['creator_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifier Id'); ?></dt>
		<dd>
			<?php echo h($eventsGuest['EventsGuest']['modifier_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($eventsGuest['EventsGuest']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($eventsGuest['EventsGuest']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Events Guest'), array('action' => 'edit', $eventsGuest['EventsGuest']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Events Guest'), array('action' => 'delete', $eventsGuest['EventsGuest']['id']), null, __('Are you sure you want to delete # %s?', $eventsGuest['EventsGuest']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Events Guests'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Events Guest'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Seats'), array('controller' => 'event_seats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Seat'), array('controller' => 'event_seats', 'action' => 'add')); ?> </li>
	</ul>
</div>
