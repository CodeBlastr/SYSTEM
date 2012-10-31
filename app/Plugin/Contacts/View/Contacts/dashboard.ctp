
<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>
<?php echo $this->Html->script('plugins/jquery.masonry.min', array('inline' => false)); ?>
  
<div class="masonry contacts dashboard">
	<div class="masonryBox tagLeads">
    	<h3><i class="icon-th-large"></i> Newest Leads </h3>
        <?php 
		if (!empty($leads)) {
			echo '<p>The latest incoming contacts, that have not been claimed yet.<p>';
			foreach ($leads as $lead) {
				echo '<p>' . $this->Html->link('Assign', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $lead['Contact']['id']), array('class' => 'btn btn-mini btn-primary')) . ' ' . $this->Html->link($lead['Contact']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $lead['Contact']['id'])) . ' ' . date('M d, Y', strtotime($lead['Contact']['created'])) . '</p>';
			}
		} 
		
		if (!empty($leadGroups)) { 
        	echo '<h4>Leads over time</h4>'; ?>
            
			<script type="text/javascript">
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawLeadsChart);
				 
			function drawLeadsChart() {
				// Create and populate the data table.
				var data = google.visualization.arrayToDataTable([
				['x', 'Date'],
				<?php 
				foreach ($leadGroups as $leadGroup) { ?>
					['<?php echo date('M d, Y', strtotime($leadGroup['Activity']['created'])); ?>',   <?php echo $leadGroup['Activity']['COUNT(`Activity`.`created`)']; ?>],
				<?php } ?>
				]);
						
				// Create and draw the visualization.
				new google.visualization.LineChart(document.getElementById('leads_over_time')).
					draw(data, {
						curveType: "function",
						width: 310, height: 200,
						legend: {position: 'none'},
						chartArea: {width: '80%', height: '80%'}
						}
					);
				$(".masonry").masonry("reload"); // reload the layout
			}
			</script>
            
 			<div id="leads_over_time"></div>
		<?php
        } ?>
	</div>
    
    
	<div class="masonryBox tagTasks">
    	<h3><i class="icon-th-large"></i> Upcoming Tasks </h3>
        <?php 
		if (!empty($tasks)) {
			echo '<p>A list of scheduled follow ups.</p>';
			foreach ($tasks as $task) {
				echo '<p>' . $this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'completed', $task['Task']['id']), array('class' => 'btn btn-mini btn-primary')) . ' ' . $this->Html->link($task['Task']['name'], array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $task['Task']['id'])) . ', due ' . date('M d, Y', strtotime($task['Task']['due_date'])) . '</p>';
			}
		} ?>
	</div>
    
    
	<div class="masonryBox tagOpportunities">
    	<h3><i class="icon-th-large"></i> Open Opportunities </h3>
        <?php 
		if (!empty($estimates)) {
			echo '<div class="alert alert-success"><h1> $'. $estimates['_total'] . '</h1></div>';
			echo '<p> Calculated by taking the total, <strong> $'. $estimates['_subTotal'] . '</strong> and multiplying by the average likelihood of closing, <strong> ' . $estimates['_multiplier'] . '%</strong></p>';
			unset($estimates['_subTotal']);
			unset($estimates['_multiplier']);
			unset($estimates['_total']);
			foreach ($estimates as $estimate) {
				echo '<p>' . $this->Html->link('Close', array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'edit', $estimate['Estimate']['id']), array('class' => 'btn btn-mini btn-primary')) . ' ' . $this->Html->link($estimate['Estimate']['name'], array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'view', $estimate['Estimate']['id'])) . '</p>';
			}
		} ?>
	</div>
    
    
</div>