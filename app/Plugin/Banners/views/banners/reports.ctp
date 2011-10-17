<?php if(isset($banners)) { ?>
<?php echo  $this->Html->script('/banners/js/jsapi.js');?>

<h2>
  <?php __('Performance');?>
</h2>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th> <div class="th1"> Total Redemptions / Clicks</div>
    </th>
    <th> <div class="th1"> <?php echo !empty($ammountReport['amount_saved']) ? 'Total Cash Saved' : ''; ?></div>
    </th>
  </tr>
  <tr>
    <td><div class="th2"> <?php echo $ammountReport['amount_redeemed']?> </div></td>
    <td><div class="th2"> <?php echo !empty($ammountReport['amount_saved']) ? $ammountReport['amount_saved'] : ''; ?> </div></td>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th> <div class="th1"> Gender </div>
    </th>
    <th> <div class="th1"> Age Group </div>
    </th>
    <th> <div class="th1"> View Count </div>
    </th>
  </tr>
  <?php 
		$count = array();
		$view_count = 0;
		foreach ($banners as $banner) {
					$count['Gender'][$banner['BannerView']['gender']] = 0 ;
					$count['Age Group'][$banner['BannerView']['age_group']] = 0 ; 
		}	
		
	foreach ($banners as $banner): ?>
  <?php	
				$count['Gender'][$banner['BannerView']['gender']] += $banner['BannerView']['count'] ;
				$count['Age Group'][$banner['BannerView']['age_group']] += $banner['BannerView']['count'];
				$view_count += $banner['BannerView']['count']; 
			?>
  <tr>
    <td><div class="th2"> <?php echo $banner['BannerView']['gender']; ?> </div></td>
    <td><div class="th2"> <?php echo $banner['BannerView']['age_group']; ?> </div></td>
    <td><div class="th2"> <?php echo $banner['BannerView']['count']; ?> </div></td>
  </tr>
  <?php endforeach; ?>
</table>
<h2> Views For Each Gender and Age Group </h2>
<table border="0" cellspacing="0" cellpadding="0">
  <?php foreach($count as $k => $val) {?>
  <tr>
    <th colspan="2"> <div class="th1"> <?php echo $k; ?> </div>
    </th>
  </tr>
  <tr>
    <?php foreach($val as $key => $value) {?>
  <tr>
    <th> <div class="th1"> <?php echo $key; ?> </div>
    </th>
    <td><div class="th2"> <?php echo $value; ?> </div></td>
  </tr>
  <?php }?>
  </tr>
  
  <?php }?>
</table>
<?php } ?>
<h3>Redemption / Click rate</h3>
<h4>
  <?php if (intval($view_count) > 0) {?>
  <?php echo (intval($redeem_count)/intval($view_count)); ?>
  <?php } else echo '0';?>
</h4>
<div id="chart_div"></div>
<script>
	//ajax call to get data for graphs of givven banner_id
	$.ajax({
        type: "POST",
		url: "/banners/banners/report_clicks/<?php echo $banner['BannerView']['banner_id']?>" ,
        dataType: "text",						 
        success:function(data){
		drawChart(data);
		}
    });	

	google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    // function for drawing graph
    function drawChart(data) {
		if (data.length > 0) {
			var response = JSON.parse(data);
			var table = new google.visualization.DataTable();
			table.addColumn('string', 'Hour');
			table.addColumn('number', 'clicks');
			table.addRows(response.length);
			// setting up each row's value
			$.each(response, function(i, item) {
				table.setValue(i, 0, item.BannerView.view_hourly);
				table.setValue(i, 1, parseInt(item.BannerView.clicks));
			});
			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(table, {width: 700, height: 300, title: 'Clicks Reports',
				vAxis: {title: 'Hour', titleTextStyle: {color: 'red'}}
			});
		}
	}
    </script>
