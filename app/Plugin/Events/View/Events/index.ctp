<div class="events index">
	<h2><?php echo __('Events');?></h2>

	<?php
	$lastDay = '';
	foreach ($events as $event) {
	    $currentDay = date('F jS, Y', strtotime($event['Event']['start']));
	    if($lastDay !== $currentDay) {
		echo '<hr /><h3>'.($currentDay).'</h3><hr />';
	    }
	    
	    echo $this->Element('singleEvent', array('event' => $event), array('plugin' => 'events'));
	    
	    $lastDay = date('F jS, Y', strtotime($event['Event']['start']));
	} // foreach($event)
	?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} events out of {:count} total, starting on event {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Event'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Event Schedules'), array('controller' => 'event_schedules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Schedule'), array('controller' => 'event_schedules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events Guests'), array('controller' => 'events_guests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Guest'), array('controller' => 'events_guests', 'action' => 'add')); ?> </li>
	</ul>
</div>
