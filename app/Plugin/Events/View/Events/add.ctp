<div class="events form">
    <?php echo $this->Form->create('Event'); ?>
    <fieldset>
	<legend><?php echo __('Add Event'); ?></legend>
	<?php
	echo $this->Form->input('event_schedule_id');
	echo $this->Form->input('name');
	echo $this->Form->input('description');
	echo $this->Form->input('start', array('class' => 'datepicker'));
	echo $this->Form->input('end');
	echo $this->Form->input('tickets_total');
	echo $this->Form->input('tickets_left');
	echo $this->Form->input('ticket_price');
	echo $this->Form->input('is_public');
//		echo $this->Form->input('creator_id');
//		echo $this->Form->input('modifier_id');
	echo $this->Form->input('Guest');
	?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>

	<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?></li>
	<li><?php echo $this->Html->link(__('List Event Schedules'), array('controller' => 'event_schedules', 'action' => 'index')); ?> </li>
	<li><?php echo $this->Html->link(__('New Event Schedule'), array('controller' => 'event_schedules', 'action' => 'add')); ?> </li>
	<li><?php echo $this->Html->link(__('List Event Venues'), array('controller' => 'event_venues', 'action' => 'index')); ?> </li>
	<li><?php echo $this->Html->link(__('New Event Venue'), array('controller' => 'event_venues', 'action' => 'add')); ?> </li>
	<li><?php echo $this->Html->link(__('List Events Guests'), array('controller' => 'events_guests', 'action' => 'index')); ?> </li>
	<li><?php echo $this->Html->link(__('New Guest'), array('controller' => 'events_guests', 'action' => 'add')); ?> </li>
    </ul>
</div>

<script type="text/javascript">
    $(function() {
	$(".datepicker").datepicker(	{
	    dateFormat: 'yy-mm-dd',
	    yearRange: '<?php echo date('Y'); ?>:<?php echo date('Y'+1); ?>',
	    changeMonth: true,
	    changeYear: true
	});
    });
</script>