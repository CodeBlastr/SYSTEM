<?php
if (isset($paginator) && !empty($paginator) && $paginator->counter(array('format' => '%pages%')) != 1) {
?>
<div class="paging">
	<p><?php echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));?></p>
    <p><?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $paginator->numbers();  ?> <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?></p>
</div>
<?php }?>


