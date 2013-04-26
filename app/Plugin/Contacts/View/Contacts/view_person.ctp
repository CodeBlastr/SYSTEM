
	
<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>

<div class="well well-large pull-right last span3">
	<?php
	if (!empty($contact['Employer'][0])) { 
		foreach ($contact['Employer'] as $employer) {
			echo __('<span class="label label-info">%s</span>', $this->Html->link($employer['name'], array('controller' => 'contacts', 'action' => 'view', $employer['id'])));
		}
	} ?>
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
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawLeadsChart);
			 
		function drawLeadsChart() {
			// Create and populate the data table.
			var data = google.visualization.arrayToDataTable([
			['x', 'Date'],
			<?php 
			foreach ($loggedActivities as $activity) { ?>
				['<?php echo date('M d, Y', strtotime($activity['Activity']['created'])); ?>',   <?php echo $activity[0]['count']; ?>],
			<?php } ?>
			]);
					
			// Create and draw the visualization.
			new google.visualization.LineChart(document.getElementById('activities_over_time')).
				draw(data, {
					curveType: "function",
					width: '100%', height: 200,
					legend: {position: 'none'},
					chartArea: {width: '80%', height: '80%'}
					}
				);
			$(".masonry").masonry("reload"); // reload the layout
		}
		</script>
        
        <h5>Activity since created</h5>
		<div id="activities_over_time"></div>
		
	<?php } ?>
</div>

<div class="contacts view pull-left span8 first">
	<?php
	echo '<h4>Contact Details ' . $this->Html->link('Add', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'add', $contact['Contact']['id']), array('class' => 'btn btn-mini btn-primary')) . '</h4>';
	if (!empty($contact['ContactDetail'])) {
		echo '<div class="span8 first pull-left"><table class="table table-hover"><tbody>';
		for ($i = 0; $i < count($contact['ContactDetail']); ++$i) {
			echo __('<tr><td class="span2">%s</td><td> %s %s </td></tr>', $contact['ContactDetail'][$i]['contact_detail_type'], $contact['ContactDetail'][$i]['value'],  $this->Html->link(__('Edit'), array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'edit', $contact['ContactDetail'][$i]['id']), array('class' => 'btn btn-mini btn-primary')));
		}
		echo "</tbody></table></div>";
	} else {
		echo __('<p>No contact details provided.</p>');
	}
	
	if (!empty($estimates)) {
		echo '<h4> Opportunities </h4>';
		echo $this->Element('scaffolds/index', array('data' => $estimates, 'modelName' => 'Estimate', 'associations' => array('Creator' => array('displayField' => 'full_name'))));
	}
	
	if (!empty($tasks)) {
		echo '<h4> Reminders </h4>';
		echo $this->Element('scaffolds/index', array('data' => $tasks, 'modelName' => 'Task', 'associations' => array('Assignee' => array('displayField' => 'full_name')), 'actions' => array($this->Html->link('Mark as Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', '{id}')))));
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
// see if the user is registered
if (empty($contact['Contact']['user_id'])) {
	$userLink =  $this->Html->link(__('Make '.$contact['Contact']['name'].' a Registered User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'register', 'contact' => $contact['Contact']['id']));
} else {
	$userLink =  $this->Html->link(__('View User', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $contact['Contact']['user_id']));
}
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
	array(
		'heading' => 'Users',
		'items' => array($userLink),
		),
	))); ?>

