<?php echo $this->Html->script('http://code.highcharts.com/highcharts.js', array('inline' => false)); ?>
<?php echo $this->Html->script('http://code.highcharts.com/modules/exporting.js', array('inline' => false)); ?>
<?php echo $this->Html->script('plugins/jquery.masonry.min', array('inline' => false)); ?>

<div class="masonry contacts dashboard">
    <div class="masonryBox dashboardBox tagLeads">
        <h3 class="title"><span class="label label-important">Attention!</span> New Leads </h3>
        <?php 
        if (!empty($leads)) {
            echo '<p>The latest incoming contacts, that have not been claimed yet.<p>';
            foreach ($leads as $lead) {
                echo '<p>' . $this->Html->link('Assign', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $lead['Contact']['id']), array('class' => 'btn btn-mini btn-primary')) . ' ' . $this->Html->link($lead['Contact']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $lead['Contact']['id'])) . ' ' . date('M d, Y', strtotime($lead['Contact']['created'])) . '</p>';
            }
            echo '<hr />';
        } else {
            echo '<p>No unassigned leads, check back soon.</p><hr />';
        }
    
        if (!empty($leadActivities)) { 
            echo '<h4>Leads over time</h4>'; ?>
            <script type="text/javascript">
            // leads chart @todo, once you have daily data convert this to zoomable too (like the above)
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'leadsTime',
                        type: 'spline'
                    },
                    credits: false,
                    title: {
                        text: false
                    },
                    subtitle: {
                        text: false
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%e. %b',
                            year: '%b'
                        }
                    },
                    yAxis: {
                        title: {
                            text: false
                        },
                        min: 0
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' m';
                        }
                    },

                    series: [{
                        name: 'Leads',
                        // Define the data points. All series have a dummy year
                        // of 1970/71 in order to be compared on the same x axis. Note
                        // that in JavaScript, months start at 0 for January, 1 for February etc.
                        data: [
                        <?php 
                        foreach ($leadActivities as $leadGroup) { ?>
                            [Date.UTC(<?php echo date('Y, n-1, d', strtotime($leadGroup['Activity']['created'])); ?>),   <?php echo $leadGroup['Activity']['COUNT(`Activity`.`created`)']; ?>],
                        <?php } ?>
                        ]
                    }]
                });
            });
            </script>
            <div id="leadsTime" style="min-width: 300px; height: 300px; margin: 0 auto"></div>
        <?php
        } ?>
    </div>
    
    <?php 
    if (!empty($estimates)) { ?>
    <div class="masonryBox dashboardBox tagOpportunities">
        <h3 class="title"><i class="icon-th-large"></i> Open Opportunities </h3>
        <?php
        echo '<div class="alert alert-success"><h1> $'. $estimates['_total'] . '</h1></div>';
        echo '<p> Calculated by taking the total, <strong> $'. $estimates['_subTotal'] . '</strong> and multiplying by the average likelihood of closing, <strong> ' . $estimates['_multiplier'] . '%</strong></p>';
		echo '<table>';
        unset($estimates['_subTotal']);
        unset($estimates['_multiplier']);
        unset($estimates['_total']);
        foreach ($estimates as $estimate) {
            echo '<tr><td>' . $this->Html->link('Close', array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'edit', $estimate['Estimate']['id']), array('class' => 'btn btn-mini btn-primary')) . '</td><td>' . $this->Html->link($estimate['Estimate']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $estimate['Estimate']['foreign_key']), array('escape' => false)) . '</td></tr>';
        }
            echo '</table><hr />';
        } 
        if (!empty($estimateActivities)) { 
            echo '<h4>Opportunities over time</h4>'; ?>
            <div id="estimates_over_time"></div>
            <script type="text/javascript">
            // leads chart @todo, once you have daily data convert this to zoomable too (like the above)
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'estimatesTime',
                        type: 'spline'
                    },
                    credits: false,
                    title: {
                        text: false
                    },
                    subtitle: {
                        text: false
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%e. %b',
                            year: '%b'
                        }
                    },
                    yAxis: {
                        title: {
                            text: false
                        },
                        min: 0
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' m';
                        }
                    },

                    series: [{
                        name: 'Opportunities',
                        // Define the data points. All series have a dummy year
                        // of 1970/71 in order to be compared on the same x axis. Note
                        // that in JavaScript, months start at 0 for January, 1 for February etc.
                        data: [
                        <?php 
                        foreach ($estimateActivities as $estimateGroup) { ?>
                            [Date.UTC(<?php echo date('Y, n-1, d', strtotime($estimateGroup['Activity']['created'])); ?>),   <?php echo $estimateGroup['Activity']['COUNT(`Activity`.`created`)']; ?>],
                        <?php } ?>
                        ]
                    }]
                });
            });
            </script>
            <div id="estimatesTime" style="min-width: 300px; height: 300px; margin: 0 auto"></div>
    </div>
    <?php
        } ?>
    
    
    <div class="masonryBox dashboardBox tagActivities">
        <h3 class="title"><i class="icon-th-large"></i> Search Contacts </h3>
        <?php   
        echo $this->Element('forms/search', array(
            'url' => '/contacts/contacts/index/', 
            'inputs' => array(
                array(
                    'name' => 'contains:name', 
                    'options' => array(
                        'label' => '', 
                        'placeholder' => 'Type Your Search and Hit Enter'
                        )
                    ),
                )
            )); ?>
    </div>
    
    
    <?php 
  if (!empty($tasks)) { ?>
  <div class="masonryBox dashboardBox tagTasks">
      <h3 class="title"><i class="icon-th-large"></i> Reminders </h3>
      <?php
      echo '<p>A list of scheduled follow ups.</p><table>';
      foreach ($tasks as $task) {
      	echo '<tr><td>' . $this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', $task['Task']['id']), array('class' => 'btn btn-mini btn-primary')) . '</td><td> ' . $this->Html->link($task['Task']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $task['Task']['foreign_key']), array('escape' => false)) . ', by ' . date('M d', strtotime($task['Task']['due_date'])) . '</td></tr>';
      }
	  echo '</table>'; ?>
  </div>
  
  <?php
  } ?>
    
    
    <?php 
  if (!empty($myContacts)) { ?>
  <div class="masonryBox dashboardBox tagMyContacts">
      <h3 class="title"><i class="icon-th-large"></i> My Contacts </h3>
      <p>The last five contacts assigned to you.</p>
    <?php
    foreach ($myContacts as $contact) {
      echo '<p>' . $this->Html->link($contact['Contact']['name'], array('action' => 'view', $contact['Contact']['id'])) . '</p>';
    } ?>
    <p class="pull-right"><?php echo $this->Html->link('View all of your contacts here', array('action' => 'index', 'filter' => 'assignee_id:' . $this->Session->read('Auth.User.id'))); ?></p>
  </div>
  <?php
  } ?>
    
    
    <?php     
  if (!empty($activities)) { ?>
  <div class="masonryBox dashboardBox tagActivities">
      <h3 class="title"><i class="icon-th-large"></i> Activity </h3>
      <?php
      $rActivities = array_reverse($activities);
      for ($i = 0; $i <= 4; $i++) {
        echo !empty($rActivities[$i]['Activity']['name']) ? '<p>' . $this->Html->link($rActivities[$i]['Activity']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $rActivities[$i]['Activity']['foreign_key'])) . '</p>' : null;
      } ?> 
        <script type="text/javascript">

        // activity over time chart
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'activityTime',
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
                    name: 'Incoming Leads',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2012, 19, 10),
                    data: [
                    <?php 
                    foreach ($activities as $activity) { ?>
                        <?php echo $activity[0]['count']; ?>,
                    <?php } ?>
                    ]
                }]
            });
        });
        </script>
        
    <h4>Activities for last 60 days</h4>
    <div id="activityTime" style="min-width: 300px; height: 300px; margin: 0 auto"></div>
    <p class="pull-right"><?php echo $this->Html->link(__('All of Today\'s Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activities', 'contains' => 'created:' . date('Y-m-d'))); ?></p>
  <?php
    } ?>
  </div>
    
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
  array(
    'heading' => 'Contacts',
    'items' => array(
      $this->Html->link(__('Dashboard'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'dashboard'), array('class' => 'active')),
      ),
    ),
  array(
    'heading' => '',
    'items' => array(
      $this->Html->link(__('Leads'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'index', 'filter' => 'contact_type:lead')),
      $this->Html->link(__('Companies'), '/contacts/contacts/index/filter:is_company:1/filter:contact_type:customer'),
      $this->Html->link(__('People'), '/contacts/contacts/index/filter:is_company:0'),
      ),
    ),
  array(
    'heading' => '',
    'items' => array(
      $this->Html->link(__('Add'), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'add')),
      ),
    ),
  ))); ?>
  

