<div class="wikis index">
<h2><?php __('Wikis');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('WikiStartPage.title');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($wikis as $wiki):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link(str_replace('_', ' ', $wiki['WikiStartPage']['title']), array('controller' => 'wiki_pages', 'action' => 'view', $wiki['Wiki']['id'], $wiki['WikiStartPage']['title'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $wiki['Wiki']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wiki['Wiki']['id'])); ?>
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

<?php 
$menu->setValue(array($html->link(__('Add Wiki', true), array('controller' => 'wikis', 'action' => 'edit'), array('title' => 'Add Wiki', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>