<div class="row">
	<div class="col-md-8">
		
		<h4><?php echo $contact['Contact']['name']; ?> 
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
			<?php for ($i = 0; $i < count($contact['ContactDetail']); ++$i) : ?>
			<hr />
			<div class="row">
				<div class="col-xs-2">
					<small class="text-muted"><?php echo $contact['ContactDetail'][$i]['contact_detail_type']; ?></small>
				</div>
				<div class="col-xs-10 no-overflow">
					<?php echo nl2br($contact['ContactDetail'][$i]['value']); ?>
				</div>
			</div>
			<?php endfor; ?>
		<?php else : ?>
			<p>No contact details provided.</p>
		<?php endif; ?>
		
		

		<?php if (!empty($employees)) : ?>
			<hr />
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
	
	<div class="contacts view col-md-4">
		<h3>Snapshot</h3>
		<div class="row table">
			<div class="col-xs-4 table-cell vertical-center text-center">
				<?php if ($contact['Contact']['contact_rating'] == 'hot') : ?>
					<?php $icon = $this->Html->link('<span class="glyphicon glyphicon-heart" style="font-size: 100px; color: #FF6677;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;"></span>', array('action' => 'rate', $contact['Contact']['id'], 'cold'), array('escape' => false)); ?>
				<?php //elseif ($contact['Contact']['contact_rating'] == 'warm') : ?>
					<?php //$icon = $this->Html->link('<span class="glyphicon glyphicon-bullhorn" style="font-size: 100px; color: #bb1111; text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;"></span>', array('action' => 'rate', $contact['Contact']['id'], 'cold'), array('escape' => false)); ?>
				<?php elseif ($contact['Contact']['contact_rating'] == 'cold') : ?>
					<?php $icon = $this->Html->link('<span class="glyphicon glyphicon-certificate" style="font-size: 100px;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;"></span>', array('action' => 'rate', $contact['Contact']['id'], 'active'), array('escape' => false)); ?>
				<?php elseif ($contact['Contact']['contact_rating'] == 'active') : ?>
					<?php $icon = $this->Html->link('<span class="glyphicon glyphicon-bell" style="font-size: 100px; color: #33FF00;text-shadow: -1px 0 black, 0 1px green, 1px 0 green, 0 -1px green;"></span>', array('action' => 'rate', $contact['Contact']['id'], 'dead'), array('escape' => false)); ?>
				<?php elseif ($contact['Contact']['contact_rating'] == 'dead') : ?>
					<?php $icon = $this->Html->link('<span class="glyphicon glyphicon-ban-circle" style="font-size: 100px; color: red;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;"></span>', array('action' => 'rate', $contact['Contact']['id'], 'hot'), array('escape' => false)); ?>
				<?php else : ?>
					<?php $icon = $this->Html->link('not rated', array('action' => 'rate', $contact['Contact']['id'], 'hot'), array('escape' => false)); ?>
				<?php endif; ?>
				<?php echo $icon; ?>
				<br /><small class="text-muted"><?php echo $this->Html->link($contact['Contact']['contact_rating'], array('action' => 'index', 'filter' => 'contact_rating:' . $contact['Contact']['contact_rating']), array('class' =>'text-muted', 'escape' => false)); ?> rating</small>
			</div>
			<div class="col-xs-8 padding-0 table-cell vertical-center">
				<p>
					<?php echo $contact['Contact']['name']; ?> was created <?php echo !empty($contact['Contact']['created']) ? $this->Html->link(ZuhaInflector::datify($contact['Contact']['created']), array('action' => 'index', 'filter' => 'created:' . $contact['Contact']['created']), array('escape' => false)) : ' no date '; ?> 
					via <?php echo !empty($contact['Contact']['contact_source']) ? $this->Html->link($contact['Contact']['contact_source'], array('action' => 'index', 'filter' => 'contact_source:' . $contact['Contact']['contact_source']), array('escape' => false)) : '<span class="list-group-item"> no source </span>'; ?>
					and is assigned to <?php echo !empty($contact['Assignee']['full_name']) ? $this->Html->link($contact['Assignee']['full_name'], array('action' => 'index', 'filter' => 'assignee_id:' . $contact['Assignee']['id']), array('escape' => false)) : ' no one '; ?>.
				</p>
				
				<span class="text-muted">Proposal(s)</span>
				<?php if (!empty($estimates)) : ?>
					<?php foreach ($estimates as $estimate) : ?>
						<?php echo $this->Html->link(ZuhaInflector::pricify($estimate['Estimate']['total'], array('currency' => 'USD', 'places' => 0)), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'estimated', $estimate['Estimate']['id']), array('class' => 'btn-block btn btn-success', 'style' => 'font-size: 40px;')); ?>
					<?php endforeach; ?>
				<?php else: ?>
					<p>No proposals created yet, <?php echo $this->Html->link(__('add one'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'estimate', $contact['Contact']['id']), array('escape' => false)); ?>.</p>
				<?php endif; ?>
				
			</div>
		</div>
		
		
		<?php if (!empty($loggedActivities)) : ?>
			<hr />
			<p>Activity over time</p>
			<?php echo $this->Chart->time($loggedActivities, array('dataTarget' => 'activityTime')); ?>
			<div id="activityTime" style="height: 150px"></div>
		<?php endif; ?>
		
		<hr />
		<h4> Reminders <small><?php echo $this->Html->link(__('Add Reminder'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'task', $contact['Contact']['id']), array('class' => 'btn btn-primary btn-xs pull-right toggleClick', 'data-target' => '#add-reminder', 'escape' => false)); ?></small></h4>
		<div id="add-reminder">
			<?php echo $this->Form->create('Task', array('url' => array('controller' => 'contacts', 'action' => 'task', $contact['Contact']['id']))); ?>
			<?php echo $this->Form->input('Task.model', array('type' => 'hidden', 'value' => 'Contact')); ?>
			<?php echo $this->Form->input('Task.foreign_key', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); ?>
			<?php echo $this->Form->input('Task.assignee_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id'))); ?>
			<?php echo $this->Form->input('Task.due_date', array('type' => 'datepicker')); ?>
			<?php echo $this->Form->input('Task.name', array('label' => 'Subject <em>(ex. Call back)</em>')); ?>
			<?php echo $this->Form->input('Task.description', array('label' => 'Optional Details <small> - supports <a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">markdown syntax</a></small>')); ?>
		  	<?php echo $this->Form->end('Add Reminder');?>
		</div>
		
		<?php if (!empty($tasks)) : ?>
			<div class="list-group">
			<?php foreach ($tasks as $task) : ?>
				<div class="list-group-item">
					<div class="row">
						<div class="col-xs-7 ellipsis">
							<?php echo $this->Html->link($task['Task']['name'], array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $task['Task']['id']), array('class' => 'toggleClick', 'data-target' => '#task' . $task['Task']['id'])); ?>
						</div>
						<div class="col-xs-5 text-right">
							<span class="badge">Due <?php echo ZuhaInflector::datify($task['Task']['due_date']); ?></span>
						</div>
					</div>
					<div class="row" id="task<?php echo $task['Task']['id']; ?>">
						<hr />
						<div class="col-xs-12">
							<p class="pull-right"><?php echo $this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', $task['Task']['id']), array('class' => 'btn btn-success btn-xs')); ?></p>
							<p><strong><?php echo $task['Task']['name']; ?></strong></p>
							<?php echo $this->Html->markdown($task['Task']['description']); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p>No reminders pending, <?php echo $this->Html->link(__('create one'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'task', $contact['Contact']['id']), array('escape' => false)); ?>.</p>
		<?php endif; ?>

		<hr />
		<h4> Activities <small><?php echo $this->Html->link(__('Log Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activity', $contact['Contact']['id']), array('class' => 'btn btn-primary btn-xs pull-right toggleClick', 'data-target' => '#log-activity', 'escape' => false)); ?></small></h4>
		<div id="log-activity">
			<?php echo $this->Form->create('Activity', array('url' => array('controller' => 'contacts', 'action' => 'activity', $contact['Contact']['id']))); ?>
			<?php echo $this->Form->input('Activity.model', array('type' => 'hidden', 'value' => 'Contact')); ?> 
			<?php echo $this->Form->input('Activity.foreign_key', array('type' => 'hidden', 'value' => $contact['Contact']['id'])); ?>
			<?php echo $this->Form->input('Activity.action_description', array('type' => 'hidden', 'value' => 'contact activity')); ?>
			<?php echo $this->Form->input('Activity.name', array('label' => 'Subject <em>(eg. Sent an email)</em>')); ?>
			<?php echo $this->Form->input('Activity.description', array('label' => 'Optional Details <small> - supports <a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">markdown syntax</a></small>')); ?>
		  	<?php echo $this->Form->end('Log Activity');?>
		</div>
		<?php if (!empty($activities)) : ?>
			<div class="list-group">
			<?php foreach ($activities as $activity) : ?>
				<div class="list-group-item">
					<div class="row">
						<div class="col-xs-7 ellipsis">
							<?php echo $this->Html->link($activity['Activity']['name'], array('plugin' => 'activities', 'controller' => 'activities', 'action' => 'view', $activity['Activity']['id']), array('title' => $activity['Activity']['description'], 'class' => 'toggleClick', 'data-target' => '#activity' . $activity['Activity']['id'])); ?>
						</div>
						<div class="col-xs-5 text-right">
							<span class="badge"><?php echo ZuhaInflector::datify($activity['Activity']['created']); ?></span>
						</div>
					</div>
					<div id="activity<?php echo $activity['Activity']['id']; ?>">
						<hr />
						<strong><?php echo $activity['Activity']['name']; ?></strong><br />
						<?php echo $this->Html->markdown($activity['Activity']['description']); ?>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p>No activities logged yet, <?php echo $this->Html->link(__('create one'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activity', $contact['Contact']['id']), array('escape' => false)); ?>.</p>
		<?php endif; ?>
		
	</div>
</div>

<?php echo $this->Html->script('http://code.highcharts.com/highcharts.js', array('inline' => false)); ?>
<?php echo $this->Html->script('http://code.highcharts.com/modules/exporting.js', array('inline' => false)); ?>
    
<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Dashboard'), array('action' => 'dashboard')),
	$contact['Contact']['name']
)));

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
			$this->Html->link(__('Create Proposal'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'estimate', $contact['Contact']['id']), array('escape' => false)),
			//$this->Html->link(__('Add Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activity', $contact['Contact']['id']), array('escape' => false)),
			//$this->Html->link(__('Add Reminder'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'task', $contact['Contact']['id']), array('escape' => false)),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('Edit %s', $contact['Contact']['name']), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $contact['Contact']['id'])),
			),
		),
	)));
