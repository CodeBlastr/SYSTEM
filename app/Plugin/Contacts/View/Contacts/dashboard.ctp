<?php echo $this->Html->script('http://code.highcharts.com/highcharts.js', array('inline' => false)); ?>
<?php echo $this->Html->script('http://code.highcharts.com/modules/exporting.js', array('inline' => false)); ?>

<div class="contacts dashboard">
	
	<div class="alert alert-success clearfix row">
		<div class="text-left col-sm-4">
			
	        <h3 class="title"><i class="icon-th-large"></i> Search Contacts </h3>
	        <?php   
	        echo $this->Element('forms/search', array('formsSearch' => array(
	        	'formOptions' => array(
					'class' => 'form',
					'url' => '/contacts/contacts/index'
					),
	            'inputs' => array(
	                array(
	                    'name' => 'contains:name', 
	                    'options' => array(
	                        'label' => '', 
	                        'placeholder' => 'Type Your Search and Hit Enter',
	                        'class' => 'input-lg'
	                        )
	                    ),
	                )
	            ))); ?>
	        <hr />
			<p>
				With <strong><?php echo !empty($estimates['_subTotal']) ? ZuhaInflector::pricify($estimates['_subTotal'], array('currency' => 'USD')) : '$0.00'; ?></strong> worth of opportunities out, 
				we might estimate <strong><?php echo ZuhaInflector::pricify(round(($estimates['_subTotal'] * ($estimates['_conversion'] / 100)), 3), array('currency' => 'USD')); ?></strong>,
				to actually be closed, over the next <strong><?php echo !empty($estimates['_cycle']) ? $estimates['_cycle'] : '0'; ?> days</strong>, based on our current conversion rate of 
				<strong><?php echo !empty($estimates['_conversion']) ? $estimates['_conversion'] : '0'; ?>%</strong>,	for proposals and our average time from proposal to sale.
			</p>
			
	    	<?php if (!empty($leadActivities)) : ?>
	    		<h3>Leads per week</h3>
	      		<?php echo $this->Chart->time($leadActivities, array('dataTarget' => 'leadsTime')); ?>
	      		<div id="leadsTime" style="height: 150px"></div>
	      	<?php endif; ?>
		</div>
	
	
	    <div class="col-sm-8">
		    <?php if (!empty($leadActivities)) : ?>
				<?php //$__userId = 67; ?>
				<?php if (!empty($myRatings[$__userId])) : ?>
					<h5><?php echo $myRatings[$__userId]['Assignee']['full_name']; ?>'s Trailing Six Month Stats</h5>
					<?php $ratings = $myRatings[$__userId]; ?>
					<ul class="list-group">
						<?php echo __('<li class="list-group-item">%s leads <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_leads'], $ratings['Assignee']['_leads_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s sales <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_sales'], $ratings['Assignee']['_sales_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s proposals <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_proposals'], $ratings['Assignee']['_proposals_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s dollars proposed <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_total'], array('currency' => 'USD')), $ratings['Assignee']['_total_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s dollars sold <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_sold'], array('currency' => 'USD')), $ratings['Assignee']['_sold_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s days average cycle <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_cycle'], $ratings['Assignee']['_cycle_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s average prop <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_averageProposal'], array('currency' => 'USD')), $ratings['Assignee']['_averageProposal_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s average sale <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_averageSale'], array('currency' => 'USD')), $ratings['Assignee']['_averageSale_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s&#37; lead to prop <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_leadToProposal'], $ratings['Assignee']['_leadToProposal_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s&#37; prop to sale <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_proposalToSale'], $ratings['Assignee']['_proposalToSale_rank'], count($myRatings)); ?>
						<?php echo __('<li class="list-group-item">%s&#37; lead to sale <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_leadToSale'], $ratings['Assignee']['_leadToSale_rank'], count($myRatings)); ?>
					</ul>
				<?php endif; ?>
	
				<?php if ($__userId == 1) : ?>
					<div class="row">
					<?php foreach ($myRatings as $key => $ratings) : ?>
						<div class="col-sm-4">
							<strong><?php echo $myRatings[$key]['Assignee']['full_name']; ?></strong>
							<ul class="list-group">
								<?php echo __('<li class="list-group-item">%s leads <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_leads'], $ratings['Assignee']['_leads_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s sales <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_sales'], $ratings['Assignee']['_sales_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s proposals <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_proposals'], $ratings['Assignee']['_proposals_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s proposed <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_total'], array('currency' => 'USD', 'places' => 0)), $ratings['Assignee']['_total_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s sold <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_sold'], array('currency' => 'USD', 'places' => 0)), $ratings['Assignee']['_sold_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s avg cycle <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_cycle'], $ratings['Assignee']['_cycle_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s avg prop <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_averageProposal'], array('currency' => 'USD', 'places' => 0)), $ratings['Assignee']['_averageProposal_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s avg sale <span class="badge">%s of %s</span></li>', ZuhaInflector::pricify($ratings['Assignee']['_averageSale'], array('currency' => 'USD', 'places' => 0)), $ratings['Assignee']['_averageSale_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s&#37; lead2prop <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_leadToProposal'], $ratings['Assignee']['_leadToProposal_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s&#37; prop2sale <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_proposalToSale'], $ratings['Assignee']['_proposalToSale_rank'], count($myRatings)); ?>
								<?php echo __('<li class="list-group-item">%s&#37; lead2sale <span class="badge">%s of %s</span></li>', $ratings['Assignee']['_leadToSale'], $ratings['Assignee']['_leadToSale_rank'], count($myRatings)); ?>
							</ul>
						</div>
					<?php endforeach; ?>
					</div>
				<?php endif; ?>
		    <?php else : ?>
		    	<h2>No sales data to show.</h2>
		    	<p>
		    		Sales data gets populated automatically by creating <?php echo $this->Html->link('estimates', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'estimates')); ?>
		    		<?php echo $this->Html->link('leads', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'add')); ?>
		    		<?php echo $this->Html->link('reminders', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'tasks')); ?> 
		    		and tracking
		    		<?php echo $this->Html->link('activities', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activity')); ?>
		    		.
		    	</p>
			<?php endif; ?>
	    </div>
	</div>
		
    <?php if (!empty($leads)) : ?>
    	<div class="col-lg-4">
        	<h3 class="title"><span class="label label-primary">Attention!</span> New Leads </h3>
        	<p>The latest incoming contacts, that have not been claimed yet.<p>
        	<?php foreach ($leads as $lead) : ?>
                <?php echo '<p>' . $this->Html->link('Assign', array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'edit', $lead['Contact']['id']), array('class' => 'btn btn-mini btn-xs btn-primary')) . ' ' . $this->Html->link($lead['Contact']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $lead['Contact']['id'])) . ' ' . date('M d, Y', strtotime($lead['Contact']['created'])) . '</p>'; ?>
            <?php endforeach; ?>
           	<hr />
		</div>
	<?php endif; ?>
    
    
    <?php if (!empty($myContacts)) : ?>
	<div class="col-sm-4">
      <h3 class="title"><i class="icon-th-large"></i> My Contacts </h3>
      <p>The last five contacts assigned to you.</p>
    	<?php foreach ($myContacts as $contact) : ?>
      		<?php echo '<p>' . $this->Html->link($contact['Contact']['name'], array('action' => 'view', $contact['Contact']['id'])) . '</p>'; ?>
   		<?php endforeach; ?>
    	<p class="pull-right"><?php echo $this->Html->link('View all of your contacts here', array('action' => 'index', 'filter' => 'assignee_id:' . $this->Session->read('Auth.User.id'))); ?></p>
	</div>
	<?php endif; ?>
	
    
    <?php if (!empty($estimates)) : ?>
	    <div class="col-sm-4">
	        <h3 class="title"><i class="icon-th-large"></i>All Open Proposals </h3>
			<div style="max-height: 200px; overflow: scroll;">
		        <?php unset($estimates['_subTotal']); ?>
		        <?php unset($estimates['_multiplier']); ?>
		       	<?php unset($estimates['_total']); ?>
		        <?php foreach ($estimates as $estimate) : ?>
		        	<?php if (!empty($estimate['Estimate'])) : ?>
		        		<div class="media">
		        			<?php echo $this->Html->link('Close', array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'edit', $estimate['Estimate']['id']), array('class' => 'btn btn-mini btn-xs btn-primary pull-left')); ?>
		        			<div class="media-body">
		        				<?php echo $this->Html->link($estimate['Estimate']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $estimate['Estimate']['foreign_key']), array('escape' => false)); ?>
		        			</div>
		        		</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
	
	
	<?php if (!empty($estimateActivities)) : ?>
	    <div class="col-sm-4">
    		<h3>Proposals by Week</h3>
            <?php echo $this->Chart->time($estimateActivities, array('dataTarget' => 'estimatesTime')); ?>
            <div id="estimatesTime" style="height: 250px;"></div>
    	</div>
    <?php endif; ?>
    
    
    <?php if (!empty($tasks)) : ?>
	<div class="col-sm-4">
		<h3> Reminders </h3>
	      <?php
	      echo '<p>A list of scheduled follow ups.</p><table>';
	      foreach ($tasks as $task) {
	      	echo '<tr><td>' . $this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', $task['Task']['id']), array('class' => 'btn btn-mini btn-xs btn-primary')) . '</td><td> ' . $this->Html->link($task['Task']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $task['Task']['foreign_key']), array('escape' => false)) . ', by ' . date('M d', strtotime($task['Task']['due_date'])) . '</td></tr>';
	      }
		  echo '</table>'; ?>
	</div>
	<?php endif; ?>
    
    
    <?php if (!empty($activities)) : ?>
	<div class="row">
		<h3> Weekly Activity <small>(26 weeks)</small> </h3>
		<?php $rActivities = array_reverse($activities); ?>
		<?php for ($i = 0; $i <= 4; $i++) : ?>
			<?php echo !empty($rActivities[$i]['Activity']['name']) ? '<p>' . $this->Html->link($rActivities[$i]['Activity']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $rActivities[$i]['Activity']['foreign_key'])) . '</p>' : null; ?>
		<?php endfor; ?>
      	<?php echo $this->Chart->time($activities, array('dataTarget' => 'activityTime')); ?>
    	<div id="activityTime" style="min-width: 300px; height: 300px; margin: 0 auto"></div>
    	<p class="pull-right"><?php echo $this->Html->link(__('All of Today\'s Activity'), array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'activities', 'contains' => 'created:' . date('Y-m-d'))); ?></p>
	</div>
    <?php endif; ?>
    
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
  

