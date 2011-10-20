<?php
if (isset($this->Paginator) && !empty($this->Paginator) && $this->Paginator->counter(array('format' => '%pages%')) != 1) {
?>
<div class="paging">
	<p><?php echo $this->Paginator->counter('Page {:page} of {:pages}, showing {:current} records out of
     {:count} total, starting on record {:start}, ending on {:end}');?></p>
    <p><?php echo $this->Paginator->prev('<< Previous', array(), null, array('class'=>'disabled'));?> | 
     <?php echo $this->Paginator->numbers();  ?> <?php echo $this->Paginator->next('Next >>', array(), null, array('class' => 'disabled'));?></p>
</div>
<?php }?>


