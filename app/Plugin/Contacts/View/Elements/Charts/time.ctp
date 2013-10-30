<?php 
/**
 * Time chart
 * 
 * Requires a few named parts of an array
 * ex. 
 * array(
 * 		0 => array(
 * 			'year' => 2013,
 * 			'month' => 9,
 * 			'day' => 4,
 * 			'formatted' => 
 * 
 */ ?>
<script type="text/javascript">

// activity over time chart
var chart;
$(document).ready(function() {
    chart = new Highcharts.Chart({
        chart: {
            renderTo: '<?php echo $dataTarget; ?>',
            zoomType: 'x',
            spacingRight: 20
        },
        credits: {
            enabled: false
        },
        title: false,
        subtitle: false,
        xAxis: {
            type: 'datetime',
            maxZoom: 14 * 24 * 3600000, // fourteen days
            title: {
                text: null
            }
        },
        yAxis: {
            title: false,
            showFirstLabel: false
        },
        tooltip: {
            shared: true
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, 'rgba(0,132,240,0)']
                    ]
                },
                lineWidth: 1,
                marker: {
                    enabled: false,
                    states: {
                        hover: {
                            enabled: true,
                            radius: 5
                        }
                    }
                },
                shadow: false,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },

        series: [{
            type: 'area',
            name: 'Activitie Logs',
            pointInterval: 24 * 3600 * 1000 * 7, // weekly
            // pointInterval: 24 * 3600 * 1000 * 7, // daily
            pointStart: Date.UTC(<?php echo $data[0]['year']; ?>, <?php echo $data[0]['month'] - 1; ?>, <?php echo $data[0]['day']; ?>),
            data: [
            <?php 
            foreach ($data as $dat) { ?>
                <?php echo $dat['count']; ?>,
            <?php } ?>
            ]
        }]
    });
});
</script>
        