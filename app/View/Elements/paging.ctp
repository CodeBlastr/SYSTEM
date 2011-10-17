<?php
if (isset($paginator) && !empty($paginator) && $this->Paginator->counter(array('format' => '%pages%')) != 1) {
?>
<div class="paging">
	<p><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));?></p>
    <p><?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers();  ?> <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?></p>
</div>
<?php }?>


