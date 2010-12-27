<div class="settings index">
<h2><?php __('Settings');?></h2>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('template_id');?></th>
	<th><?php echo $paginator->sort('plugin');?></th>
	<th><?php echo $paginator->sort('controller');?></th>
	<th><?php echo $paginator->sort('action');?></th>
	<th><?php echo $paginator->sort('parameter');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($templates as $template):
    if (empty($template)) continue;
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
        <td>
			<?php echo $template['Template']['id'] + 1; ?>
		</td>
		<td>
			<?php echo $template['Template']['template_id']; ?>
		</td>
		<td>
			<?php echo $template['Template']['plugin']; ?>
		</td>
		<td>
			<?php echo $template['Template']['controller']; ?>
		</td>
		<td>
			<?php echo $template['Template']['action']; ?>
		</td>
		<td>
			<?php echo $template['Template']['parameter']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action' => 'templates_edit', $i)); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'templates_delete', $i), null, sprintf(__('Are you sure you want to delete # %s?', true), $i)); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Template Setting', true), array('action' => 'templates_add')); ?></li>
	</ul>
</div>
