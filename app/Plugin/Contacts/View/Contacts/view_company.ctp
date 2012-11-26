<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>

<div class="well well-large pull-right last span3">
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_rating']) ? Inflector::humanize($contact['Contact']['contact_rating']) : 'Unrated'; ?> <?php echo !empty($contact['Contact']['contact_type']) ? $contact['Contact']['contact_type'] : 'Uncategorized'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_industry']) ? $contact['Contact']['contact_industry'] : 'Uncategorized'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_source']) ? $contact['Contact']['contact_source'] : 'Unsourced'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['created']) ? ZuhaInflector::datify($contact['Contact']['created']) : 'Undated'; ?></span>
	<?php
	if (!empty($loggedEstimates)) {
		echo '<h5>Open Opportunity</h5>';
		echo '<div class="alert alert-success"><h1> $'. $loggedEstimates['_total'] . '</h1></div>';
		echo '<p> Calculated by taking the total, <strong> $'. $loggedEstimates['_subTotal'] . '</strong> and multiplying by the average likelihood of closing, <strong> ' . $loggedEstimates['_multiplier'] . '%</strong></p>';
	}
	if (!empty($loggedActivities)) { ?>
        <h5>Activity over time</h5>
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawLeadsChart);
			 
		function drawLeadsChart() {
			// Create and populate the data table.
			var data = google.visualization.arrayToDataTable([
			['x', 'Date'],
			<?php 
			foreach ($loggedActivities as $activity) { ?>
				['<?php echo date('M d, Y', strtotime($activity['Activity']['created'])); ?>',   <?php echo $activity['Activity']['COUNT(`Activity`.`created`)']; ?>],
			<?php } ?>
			]);
					
			// Create and draw the visualization.
			new google.visualization.LineChart(document.getElementById('activities_over_time')).
				draw(data, {
					curveType: "function",
					width: 270, height: 200,
					legend: {position: 'none'},
					chartArea: {width: '80%', height: '80%'}
					}
				);
			$(".masonry").masonry("reload"); // reload the layout
		}
		</script>
        
		<div id="activities_over_time"></div>
		
	<?php } ?>
	<div class="contact form">
		<?php echo $this->Form->create('Contact', array('url' => array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'add')));?>
		<fieldset>
			<legend class="btn btn-block toggleClick"><?php echo __('Add Employee'); ?></legend>
		    <?php
			 echo $this->Form->hidden('Contact.is_company', array('value' => 0));
			 echo $this->Form->hidden('Employer', array('value' => $contact['Contact']['id']));
			 echo $this->Form->input('Contact.id', array('type' => 'select', 'options' => $people, 'label' => __('Employee <small>%s</small>', $this->Html->link('(create new person)', '#', array('id' => 'newEmployeeLink')))));
			 echo $this->Form->input('Contact.name', array('label' => 'Employee Name', 'after' => __(' %s', $this->Html->link('Cancel', '#', array('id' => 'cancelEmployeeLink')))));
			 echo $this->Form->end('Submit');?>
		</fieldset>
	</div>
	<script type="text/javascript">		
		$(function() {
			$("#ContactName").parent().hide();
			$("#newEmployeeLink").click(function () {
				$(this).parent().hide();
				$("#ContactName").parent().show();
			});
			$("#cancelEmployeeLink").click(function () {
				$(this).parent().hide();
				$("#ContactId").parent().show();
			});
		});
	</script>
</div>

<div class="contacts view">
	<?php
	echo '<h4>Contact Details ' . $this->Html->link('Add', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'add', $contact['Contact']['id']), array('class' => 'btn btn-mini btn-primary')) . '</h4>';
	if (!empty($contact['ContactDetail'])) { 
		for ($i = 0; $i < count($contact['ContactDetail']); ++$i) {
			echo __('<p><span class="label label-info">%s</span> %s</p>', $contact['ContactDetail'][$i]['contact_detail_type'], $this->Html->link(__('%s', $contact['ContactDetail'][$i]['value']), array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'edit', $contact['ContactDetail'][$i]['id'])));
		}
	} else {
		echo __('<p>No contact details provided.</p>');
	}
	
	if (!empty($estimates)) {
		echo '<h4> Opportunities </h4>';
		echo $this->Element('scaffolds/index', array('data' => $estimates, 'modelName' => 'Estimate'));
	}
	
	if (!empty($tasks)) {
		echo '<h4> Reminders </h4>';
		echo $this->Element('scaffolds/index', array('data' => $tasks, 'modelName' => 'Task', 'actions' => array($this->Html->link('Mark as Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', '{id}')))));
	}
	
	if (!empty($activities)) {
		echo '<h4> Activities </h4>';
		echo $this->Element('scaffolds/index', array('data' => $activities, 'modelName' => 'Activity', 'associations' => array('Creator' => array('displayField' => 'full_name'))));
	}
	
	if (!empty($employees)) {
		echo '<h4> Employees </h4>';
		echo $this->Element('scaffolds/index', array('data' => $employees));
	} ?>	
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
	))); ?>
