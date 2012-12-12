<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>


<div class="contacts view">
	<?php //debug($option);
	echo '<h4>Job Details</h4>';
	if (count($job) > 0) {
		echo '<div><table class="table table-hover"><tbody>';
		echo __('<tr><td class="span2">Title</td><td>'.$job['Job']['title'].'</td></tr>');
		echo __('<tr><td class="span2">Description</td><td>'.$job['Job']['description'].'</td></tr>'); 
        echo __('<tr><td class="span2">Budget</td><td>$ '.$job['Job']['budget'].'</td></tr>'); 
        echo __('<tr><td class="span2">Acreage</td><td> '.$job['Job']['!acreage'].'</td></tr>'); 
        echo __('<tr><td class="span2">Address</td><td> '.$job['Job']['!address'].'</td></tr>');
        echo __('<tr><td class="span2">City</td><td> '.$job['Job']['!city'].'</td></tr>');
        echo __('<tr><td class="span2">State</td><td> '.$job['Job']['!state'].'</td></tr>');
        echo __('<tr><td class="span2">Status</td><td>'.$job['Job']['status'].'</td></tr>'); 
		echo "</tbody></table></div>"; ?>
        <div class="itemGallery productGallery"> <?php echo $this->Element('gallery', array('model' => 'Job', 'foreignKey' => $job['Job']['id']), array('plugin' => 'galleries')); ?>
        </div> 
	<?php } else {
		echo __('<p>No job details provided.</p>');
	}
	
	if (!empty($estimates)) {
		    echo '<h4>Bids ' . $this->Html->link('Add', array('controller' => 'jobs', 'action' => 'estimate', $job['Job']['id']), array('class' => 'btn btn-mini btn-primary')) . '</h4>';  
		echo $this->Element('scaffolds/index', array('data' => $estimates, 'modelName' => 'Estimate', 'associations' => array('Creator' => array('displayField' => 'full_name'))));
	}
	
	 ?>	
</div>


        
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('Lists'), array('plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'index')),
			),
		),
	
	))); ?>
