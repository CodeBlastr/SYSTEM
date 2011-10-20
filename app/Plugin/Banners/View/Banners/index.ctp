<div class="banners index">
	<h2><?php echo __('Banners');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><div class="th1"><?php echo $this->Paginator->sort('name');?></div></th>
			<th><div class="th1"><?php echo $this->Paginator->sort('schedule_start_date');?></div></th>
			<th><div class="th1"><?php echo $this->Paginator->sort('schedule_end_date');?></div></th>
			<th><div class="th1"><?php echo $this->Paginator->sort('gender');?></div></th>
			<th><div class="th1"><?php echo $this->Paginator->sort('age_group');?></div></th>
	</tr>
	<?php
	$i = 0;
	foreach ($banners as $banner):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><div class="th2"><?php echo $this->Html->link($banner['Banner']['name'], array('controller' => 'banners', 'action' => 'preview', $banner['Banner']['id'])); ?>&nbsp;</div></td>
		<td><div class="th2"><?php echo $banner['Banner']['schedule_start_date']; ?>&nbsp;</div></td>
		<td><div class="th2"><?php echo $banner['Banner']['schedule_end_date']; ?>&nbsp;</div></td>
		<td><div class="th2"><?php echo $banner['Banner']['gender']; ?>&nbsp;</div></td>
		<td><div class="th2"><?php echo $banner['Banner']['age_group']; ?>&nbsp;</div></td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>