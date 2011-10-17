<div class="webpageCsses index">
	<h2><?php __('Webpage Csses');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($webpageCsses as $webpageCss):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $webpageCss['WebpageCss']['type']; ?>&nbsp;</td>
		<td><?php echo $webpageCss['WebpageCss']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $webpageCss['WebpageCss']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $webpageCss['WebpageCss']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $webpageCss['WebpageCss']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $webpageCss['WebpageCss']['id'])); ?>
		</td>
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
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Webpage Css', true), array('action' => 'add')); ?></li>
	</ul>
</div>