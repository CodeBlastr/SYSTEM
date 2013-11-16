<div class="row">
	<div class="well well-large pull-right last span3 col-md-5">

		<div class="col-md-12 clearfix">
			<h4><?php echo $contact['Contact']['name']; ?>'s Details 
				<?php echo $this->Html->link('Add Detail', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'add', $contact['Contact']['id']), array('class' => 'btn btn-mini btn-xs btn-primary toggleClick', 'data-target' => '#ContactDetailAddForm')); ?>
				<?php echo $this->Html->link(__('Add Employee'), '', array('class' => 'btn btn-xs btn-primary toggleClick addEmployeeBtn', 'data-target' => '.employeeSelect, .employeeSubmit')); ?>
			</h4>
						
			<?php echo $this->Form->create('Contact', array('url' => array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'add')));?>
			<?php echo $this->Form->hidden('Contact.is_company', array('value' => 0)); ?>
			<?php echo $this->Form->hidden('Employer', array('value' => $contact['Contact']['id'])); ?>
			<?php echo $this->Form->input('Contact.id', array('div' => array('class' => 'employeeSelect'), 'empty' => '-- Select --', 'type' => 'select', 'options' => $people, 'label' => __('Choose Person <small>%s</small>', $this->Html->link('(create new person)', '', array('class' => 'toggleClick', 'data-target' => '.employeeSelect, .employeeInput'))))); ?>
			<?php echo $this->Form->input('Contact.name', array('div' => array('class' => 'employeeInput'), 'label' => 'Employee\'s Name', 'after' => __(' %s', $this->Html->link('Cancel', '', array('class' => 'toggleClick', 'data-target' => '.employeeInput, .employeeSelect'))))); ?>
			<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'employeeSubmit'));?>
			
			<?php echo $this->Form->create('ContactDetail', array('id' => 'ContactDetailAddForm', 'url' => array('controller' => 'contact_details', 'action' => 'add')));?>
			<?php echo $this->Form->input('ContactDetail.contact_id', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); ?>
			<?php echo $this->Form->input('Override.redirect', array('type' => 'hidden', 'value' => '/contacts/contacts/view/' . $contact['Contact']['id'])); ?>
			<?php echo $this->Form->input('ContactDetail.contact_detail_type', array('label' => false)); ?>
			<?php echo $this->Form->input('ContactDetail.value', array('type' => 'text', 'label' => false, 'placeholder' => 'Enter Detail Value')); ?>
			<?php echo $this->Form->end(__('Submit')); ?>
			
			
			<?php if (!empty($contact['ContactDetail'])) : ?>
				<table class="table table-condensed table-fixed">
					<tbody>
						<?php for ($i = 0; $i < count($contact['ContactDetail']); ++$i) : ?>
							<tr>
								<td><small class="text-muted"><?php echo $contact['ContactDetail'][$i]['contact_detail_type']; ?></small></td>
								<td><?php echo $contact['ContactDetail'][$i]['value']; ?></td>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			<?php else : ?>
				<p>No contact details provided.</p>
			<?php endif; ?>
		</div>
		
		<div class="col-md-12">
			<div class="list-group">
				<?php echo !empty($contact['Contact']['contact_rating']) ? $this->Html->link($contact['Contact']['contact_rating'] . '<span class="badge">rating</span>', array('action' => 'index', 'filter' => 'contact_rating:' . $contact['Contact']['contact_rating']), array('class' => 'list-group-item', 'escape' => false)) : '<span class="list-group-item">Unrated</span>'; ?>
				<?php echo !empty($contact['Contact']['contact_source']) ? $this->Html->link($contact['Contact']['contact_source'] . '<span class="badge">source</span>', array('action' => 'index', 'filter' => 'contact_source:' . $contact['Contact']['contact_source']), array('class' => 'list-group-item', 'escape' => false)) : '<span class="list-group-item">Unsourced</span>'; ?>
				<?php echo !empty($contact['Assignee']['full_name']) ? $this->Html->link($contact['Assignee']['full_name'] . '<span class="badge">assigned</span>', array('action' => 'index', 'filter' => 'assignee_id:' . $contact['Assignee']['id']), array('class' => 'list-group-item', 'escape' => false)) : '<span class="list-group-item">Unassigned</span>'; ?>
				<?php echo !empty($contact['Contact']['created']) ? $this->Html->link(ZuhaInflector::datify($contact['Contact']['created']) . '<span class="badge">created</span>', array('action' => 'index', 'filter' => 'created:' . $contact['Contact']['created']), array('class' => 'list-group-item', 'escape' => false)) : '<span class="list-group-item">No Date</span>'; ?>
			</div>
		</div>

		<?php if (!empty($loggedEstimates['_subTotal'])) : ?>
		<div class="col-md-12 clearfix">
			<h5>Open Opportunity</h5>
			<div class="alert alert-success">
				<h1> <?php echo ZuhaInflector::pricify($loggedEstimates['_total'], array('currency' => 'USD')); ?></h1>
			</div>
			<p> Calculated by taking the total, <strong><?php echo ZuhaInflector::pricify($loggedEstimates['_subTotal'], array('currency' => 'USD')); ?></strong> 
				and multiplying by the average likelihood of closing, <strong><?php echo $loggedEstimates['_multiplier']; ?>%</strong>
			</p>
		</div>
		<?php endif; ?>
		
		<?php if (!empty($loggedActivities)) : ?>
		<div class="col-md-12">
			<?php echo $this->Chart->time($loggedActivities, array('dataTarget' => 'activityTime')); ?>
			<div id="activityTime"></div>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="contacts view span8 col-md-7">
		
		<?php if (!empty($estimates)) : ?>
			<h4> Opportunities </h4>
			<div class="list-group">
			<?php foreach ($estimates as $estimate) : ?>
				<div class="list-group-item">
					<?php echo $this->Html->link($estimate['Estimate']['name'], array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'view', $estimate['Estimate']['id'])); ?>
				</div>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		
		<?php if (!empty($tasks)) : ?>
			<h4> Reminders </h4>
			<div class="list-group">
			<?php foreach ($tasks as $task) : ?>
				<div class="list-group-item">
					<?php echo $this->Html->link($task['Task']['name'], array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $task['Task']['id'])); ?>
					<span class="badge"><?php echo ZuhaInflector::datify($task['Task']['created']); ?></span>
				</div>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		
		<?php if (!empty($activities)) : ?>
			<h4> Activities </h4>
			<div class="list-group">
			<?php foreach ($activities as $activity) : ?>
				<div class="list-group-item">
					<?php echo $this->Html->link($activity['Activity']['name'], array('plugin' => 'activities', 'controller' => 'activities', 'action' => 'view', $activity['Activity']['id'])); ?>
					<span class="badge"><?php echo ZuhaInflector::datify($activity['Activity']['created']); ?></span>
				</div>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		
		<?php if (!empty($employees)) : ?>
			<h4> Employees </h4>
			<div class="list-group">
			<?php foreach ($employees as $employee) : ?>
				<div class="list-group-item">
					<?php echo $this->Html->link($employee['Contact']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $employee['Contact']['id'])); ?>
				</div>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>	
	</div>
</div>

        
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Dashboard'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard')),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Opportunity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'estimate', $contact['Contact']['id']), array('escape' => false)),
			$this->Html->link(__('Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activity', $contact['Contact']['id']), array('escape' => false)),
			$this->Html->link(__('Reminder'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'task', $contact['Contact']['id']), array('escape' => false)),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('List'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'index')),
			$this->Html->link(__('Edit'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $contact['Contact']['id'])),
			),
		),
	)));
