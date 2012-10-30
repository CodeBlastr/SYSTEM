
<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>
<?php echo $this->Html->script('plugins/jquery.masonry.min', array('inline' => false)); ?>
  
<div class="masonry contacts dashboard">
	<div class="masonryBox tagLeads">
    	<h3><i class="icon-th-large"></i> Needs Your Attention Today </h3>
        <?php 
		if (!empty($leads)) {
			echo '<p>The latest incoming contacts, that have not been claimed yet.<ul>';
			foreach ($leads as $lead) {
				echo '<li>' . $this->Html->link('Assign', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $lead['Contact']['id']), array('class' => 'btn btn-mini btn-primary')) . ' ' . $this->Html->link($lead['Contact']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $lead['Contact']['id'])) . ' ' . date('M d, Y', strtotime($lead['Contact']['created'])) . '</li>';
			}
			echo '</ul>';
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
    
    
</div>