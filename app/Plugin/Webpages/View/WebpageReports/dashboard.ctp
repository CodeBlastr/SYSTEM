<div class="accordion">
  <ul>
    <li> <a href="#"><span>Reports</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Analytics', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'dashboard')); ?></li>
    <li><?php echo $this->Html->link('Reports', array('plugin' => 'reports', 'controller' => 'reports', 'action' => 'index')); ?></li>
  </ul>
</div>

<div class="reports dashboard">

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Pageviews');
        data.addColumn('number', 'Visits');
		<?php foreach ($chartData as $data) { if (is_array($data)) { ?>
		
        data.addRow(["<?php echo $data['date']; ?>", <?php echo $data['pageviews']; ?>, <?php echo $data['visits']; ?>]);
		<?php } } ?>
       
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: 600, height: 400,
                        vAxis: {maxValue: <?php echo $chartData['totalPageViews']; ?>},
                        vAxis: {minValue: 0}}
                );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
<?php if (!empty($chartData)) { ?>
<h3>Last 30 Days of Site Traffic</h3>
<div id="visualization" style="width: 600px; height: 400px;"></div>
<?php } ?>

</div>