<div class="indexContainer"> 
  <h2><span>Posted Jobs Lists</span></h2>    
<?php
  $jobs_count=count($jobs);
  if($jobs_count > 0) {   
  foreach ($jobs as $jobs_details) { 
  //echo $this->Element('Category/lists', array('model' => 'Job', 'foreignKey' => $jobs_details['Job']['id'],'jobsId' => $jobs_details['Job']['id'])); 
  ?>
  
<div class="indexrow">
    <div class="rowcell pic-con">
    <div class="pic-thum"><?php echo $this->Element('gallery', array('model' => 'Job', 'foreignKey' => $jobs_details['Job']['id']), array('plugin' => 'galleries')); ?></div>
    </div>

    <div class="rowcell comp-con">
        <div class="cat-tile">
        <div class="category">Category: <span class="green">Lawn, Mowing</span></div>

        <div class="location">Location: <span><?php echo $jobs_details['Job']['!city']; ?></span></div>
        </div>

        <div class="com-details">
        <h2><?php echo $this->Html->link($jobs_details['Job']['title'],array('controller' => 'jobs', 'action' => 'view',$jobs_details['Job']['id'])); ?></h2>

        <p class="description"><?php echo $jobs_details['Job']['description']; ?><br><?php echo $this->Html->link('Read More',array('controller' => 'jobs', 'action' => 'view',$jobs_details['Job']['id']),array('class'=>'pull-right')); ?></div>
    </div>

    <div class="rowcell rev-con">
        <div class="rev-tile">
         
   <div>&nbsp;&nbsp;<?php echo $this->Html->link('Make a Bid',array('controller' => 'jobs', 'action' => 'estimate',$jobs_details['Job']['id'])); ?>&nbsp;&nbsp;&nbsp;$<?php echo $jobs_details['Job']['budget']; ?></div>
        </div>

<div class="rev-from"><span><?php echo $jobs_details['Job']['!address']; ?></span>
 <span><?php echo $jobs_details['Job']['!city']; ?>, <?php echo $jobs_details['Job']['!state']; ?></span></div>                                                     
 </div> 
   </div> 

 
<?php }  } else { ?>
 
 
<?php }  ?> </div> 