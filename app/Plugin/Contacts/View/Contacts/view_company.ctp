<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>

<div class="well well-large pull-right last span3">
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_rating']) ? Inflector::humanize($contact['Contact']['contact_rating']) : Unrated; ?> <?php echo !empty($contact['Contact']['contact_type']) ? $contact['Contact']['contact_type'] : 'Uncategorized'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_industry']) ? $contact['Contact']['contact_industry'] : 'Uncategorized'; ?></span>
	<span class="label label-info"><?php echo !empty($contact['Contact']['contact_source']) ? $contact['Contact']['contact_source'] : 'Unsourced'; ?></span>
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
</div>

<div class="contacts view">
	<?php
	echo '<h4>Contact Details ' . $this->Html->link('Add', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'add', $contact['Contact']['id']), array('class' => 'btn btn-mini btn-primary')) . '</h4>';
	if (!empty($contact['ContactDetail'])) { 
		for ($i = 0; $i < count($contact['ContactDetail']); ++$i) {
			echo __('<p>%s %s</p>', $this->Html->link(__('%s : %s', $contact['ContactDetail'][$i]['contact_detail_type'], $contact['ContactDetail'][$i]['value']), array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'edit', $contact['ContactDetail'][$i]['id'])), $this->Html->link('Delete', array('plugin' => 'contacts', 'controller' => 'contact_details', 'action' => 'delete', $contact['ContactDetail'][$i]['id']), array('class' => 'btn btn-mini btn-danger')));
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
		echo $this->Element('scaffolds/index', array('data' => $tasks, 'modelName' => 'Task'));
	}
	
	if (!empty($activities)) {
		echo '<h4> Activities </h4>';
		echo $this->Element('scaffolds/index', array('data' => $activities, 'modelName' => 'Activity'));
	}
	
	if (!empty($employees)) {
		echo '<h4> Employees </h4>';
		echo $this->Element('scaffolds/index', array('data' => $employees));
	}  ?>

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
			$this->Html->link(__('<i class="icon-plus"></i> Opportunity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'estimate', $contact['Contact']['id']), array('escape' => false)),
			$this->Html->link(__('<i class="icon-plus"></i> Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activity', $contact['Contact']['id']), array('escape' => false)),
			$this->Html->link(__('<i class="icon-plus"></i> Reminder'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'task', $contact['Contact']['id']), array('escape' => false)),
			),
		),
	array(
		'heading' => 'Contacts',
		'items' => array(
			$this->Html->link(__('List'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'index')),
			$this->Html->link(__('Edit'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $contact['Contact']['id'])),
			$this->Html->link(__('<i class="icon-plus"></i> Employee'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'add', 'person', $contact['Contact']['id']), array('escape' => false)),
			),
		),
	))); ?>
