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
            echo '<h4>Leads over time</h4>'; 
           // echo $this->Chart->time(); ?>
            
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
    if (!empty($estimates)) : ?>
	    <div class="masonryBox dashboardBox tagOpportunities">
	        <h3 class="title"><i class="icon-th-large"></i>Opportunities </h3>
	       	<div class="alert alert-success clearfix">
	       		<div class="pull-left"> 
	       			<?php echo ZuhaInflector::pricify($estimates['_subTotal']); ?> Out
	       			<h1> $<?php echo ZuhaInflector::pricify($estimates['_total']); ?></h1>
	       		</div>
	       	<div class="pull-right">
	       		Est. Conversion 
	       		<h1> <?php echo intval($estimates['_multiplier']); ?>%</h1>
	       	</div>
		</div>
		<div class="alert alert-info clearfix">
			<div class="pull-left">
				<?php echo ZuhaInflector::pricify($estimates['_subTotal']); ?> Out
				<h1> $<?php echo ZuhaInflector::pricify(round(($estimates['_subTotal'] * ($estimates['_conversion'] / 100)), 3)); ?></h1>
			</div>
			<div class="pull-right">
				Act. Conversion
				<h1><?php echo $estimates['_conversion']; ?>%</h1>
			</div>
		</div>
		<div style="max-height: 200px; overflow: scroll;">
	        <?php
	        unset($estimates['_subTotal']);
	        unset($estimates['_multiplier']);
	        unset($estimates['_total']);
	        foreach ($estimates as $estimate) :
	        	if (!empty($estimate['Estimate'])) : ?>
	        		<div class="media">
	        			<?php echo $this->Html->link('Close', array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'edit', $estimate['Estimate']['id']), array('class' => 'btn btn-mini btn-primary pull-left')); ?>
	        			<div class="media-body">
	        				<?php echo $this->Html->link($estimate['Estimate']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $estimate['Estimate']['foreign_key']), array('escape' => false)); ?>
	        			</div>
	        		</div>
				<?php endif; ?>
			<?php endforeach; ?>
        </div><hr />
	<?php endif; ?>
	<?php
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
        echo $this->Element('forms/search', array('forms_search' => array(
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
            ))); ?>
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
    
    
    <?php if (!empty($activities)) : ?>
	<div class="masonryBox dashboardBox tagActivities">
		<h3 class="title"><i class="icon-th-large"></i> Weekly Activity <small>(26 weeks)</small> </h3>
		<?php $rActivities = array_reverse($activities); ?>
		<?php for ($i = 0; $i <= 4; $i++) : ?>
			<?php echo !empty($rActivities[$i]['Activity']['name']) ? '<p>' . $this->Html->link($rActivities[$i]['Activity']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $rActivities[$i]['Activity']['foreign_key'])) . '</p>' : null; ?>
		<?php endfor; ?>
      	<?php echo $this->Chart->time($activities, array('dataTarget' => 'activityTime')); ?>
    	<div id="activityTime" style="min-width: 300px; height: 300px; margin: 0 auto"></div>
    	<p class="pull-right"><?php echo $this->Html->link(__('All of Today\'s Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activities', 'contains' => 'created:' . date('Y-m-d'))); ?></p>
	<?php endif; ?>
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
  

