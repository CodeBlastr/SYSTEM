<div class="index">
	<div class="<?php echo $model; ?> form">
<?php echo $form->create($model);?>
	<fieldset>
 		<legend><?php __('Add '.$model);?></legend>
	<?php
		echo $form->input('id');
		if ($autocomplete) {
			echo $ajax->autoComplete($model.'.name', '/admin/'.strtolower($model).'s/ajax_complete', array('minChars' => '2', 'frequency' => '3'));
		} else {
			echo $form->input('name');
		}
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
	</div>

<!-- p><?php //echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></p -->

<?php # shows a sortable link # echo $paginator->sort('name'); ?>
<div class="<?php __($controller); ?> data">
	<h6><?php __('Edit / Delete '.$controller);?></h6>
	<ul class="<?php __($model); ?> datalist">
<?php
$i = 0;
foreach ($outputs as $output):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
		<li <?php echo $class;?>>
			<span id="typename<?php echo $output[$model]['id']; ?>"><?php echo $output[$model]['name']; ?></span>
<?php echo $ajax->editor('typename'.$output[$model]['id'],'ajax_update/'.$output[$model]['id'].'/name/'.$model,array("okControl" => "button","cancelControl" => "link","clickToEditText" => "Click to edit","submitOnBlur" => "false")); ?><p class="action"><?php echo $ajax->link('X', array('controller' => $controller, 'action' => 'ajax_delete', $output[$model]['id']), array('indicator' => 'loadingimg', 'update' => 'typename'.$output[$model]['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Are you sure you want to delete "'.$output[$model]['name'].'"'); ?></p>
		</li>
<?php endforeach; ?>
	</ul>
</div>
<!-- div class="paging">
	<?php // echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php // echo $paginator->numbers();?>
	<?php // echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div -->