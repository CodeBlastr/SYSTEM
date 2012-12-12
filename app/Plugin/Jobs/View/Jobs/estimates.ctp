<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>


<div class="contacts view">
	<?php //debug($option);
	echo '<h4>Job Details</h4>';
	if (count($job) > 0) {
		echo '<div><table class="table table-hover"><tbody>';
		echo __('<tr><td class="span2">Title</td><td>'.$job['Job']['title'].'</td></tr>');
		echo __('<tr><td class="span2">Description</td><td>'.$job['Job']['description'].'</td></tr>'); 
        echo __('<tr><td class="span2">Budget</td><td>$ '.$job['Job']['budget'].'</td></tr>'); 
        echo __('<tr><td class="span2">Status</td><td>'.$job['Job']['status'].'</td></tr>'); 
		echo "</tbody></table></div>";
	} else {
		echo __('<p>No job details provided.</p>');
	}
	//debug($estimates);
	if (!empty($estimates)) {
		    echo '<h4>Bids</h4>';  
	//	echo $this->Element('scaffolds/index', array('data' => $estimates, 'modelName' => 'Estimate', 'associations' => array('Creator' => array('displayField' => 'full_name'))));    ?>
  <?php foreach($estimates as $estimates_details) { ?>
<div id="row<?php echo $estimates_details['Estimate']['id'];?>" class="indexRow  navbar">
<div class="container">
<a data-target=".nav-collapse1" data-toggle="collapse" class="btn btn-navbar" style="cursor: pointer;">
<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span><b class="caret"></b></a>
<div class="indexCell imageCell" style="display: none;"> <span> </span> </div>

<div class="indexCell indexData">
<div class="indexCell titleCell brand">
<div class="recorddat">
<h3> <a class="view" href="/estimates/estimates/view/<?php echo $estimates_details['Estimate']['id'];?>"><?php echo $estimates_details['Estimate']['name'];?></a></h3>
</div>
</div><div class="indexCell actionCell nav-collapse nav-collapse1">
<div class="drop-holder indexDrop actions">
<ul class="drop nav">
<li>
 <?php
echo $this->Form->create('TransactionItem', array('url' => array('plugin' => 'transactions', 'controller'=>'transaction_items', 'action'=>'add')));
echo $this->Form->hidden('TransactionItem.quantity' , array('label' => ' Quantity ', 'value' => 1));
echo $this->Form->hidden('TransactionItem.parent_id' , array('value' => $estimates_details['Estimate']['id']));
echo $this->Form->hidden('TransactionItem.model' , array('value' => 'Job'));
echo $this->Form->hidden('TransactionItem.name' , array('value' => $estimates_details['Creator']['full_name']));  
echo $this->Form->hidden('TransactionItem.foreign_key' , array('value' => $estimates_details['Estimate']['id']));
echo $this->Form->hidden('TransactionItem.price' , array('value' => $estimates_details['Estimate']['total']));
echo $this->Form->hidden('TransactionItem.payment_type' , array('value' => 'PAYSIMPLE'));
echo $this->Form->hidden('TransactionItem.is_virtual' , array('value' => '1'));
echo $this->Form->end('Accept Bid');
            ?>

</li>

</ul>
</div>
</div>
<div class="indexCell descriptionCell">
<div class="recorddat">
<div class="truncate"> <span id="<?php echo $estimates_details['Estimate']['id'];?>" name="description"></span> </div>
</div>
</div>

<div class="indexCell metaCell nav-collapse nav-collapse1">
<ul class="metaData">
<li class="metaDataLi Created"><span class="metaDataLabel Created"> Created : </span><span id="<?php echo $estimates_details['Estimate']['id'];?>" name="Created" class="metaDataDetail"><?php echo $estimates_details['Estimate']['created'];?></span></li>
<li class="metaDataLi Creator"><span class="metaDataLabel Creator"> Creator : </span><span id="<?php echo $estimates_details['Estimate']['id'];?>" name="Creator" class="metaDataDetail"><?php echo $estimates_details['Creator']['full_name'];?></span></li>
</ul>
</div></div>
</div></div>  
<?php  }
   // debug($estimates);
    }
	
	 ?>	
</div>


        
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('Lists'), array('plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'my')),
			),
		),
	
	))); ?>
