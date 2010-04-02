<div class="webapges index">
	<h2><?php __('Webpages');?></h2>
	<p>
		<?php
			echo $paginator->counter(array(
			'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
			));
		?>
	</p>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $paginator->sort('id');?></th>
		<th><?php echo $paginator->sort('name');?></th>
		<th><?php echo $paginator->sort('alias');?></th>
		<th><?php echo $paginator->sort('created');?></th>
		<th><?php echo $paginator->sort('modified');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($webpages as $webpage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $webpage['Webpage']['id']; ?>
		</td>
		<td>
			<?php echo $webpage['Webpage']['name']; ?>
		</td>
		<td>
			<?php echo $webpage['Webpage']['alias']; ?>
		</td>
		<td>
			<?php echo $webpage['Webpage']['created']; ?>
		</td>
		<td>
			<?php echo $webpage['Webpage']['modified']; ?>
		</td>
		<td class="actions">
			<a href="<?php echo $this->webroot."webpages/preview/{$webpage["Webpage"]["alias"]}" ?>">Preview</a>
			<?php echo $html->link(__('View', true), array('action' => 'view', $webpage['Webpage']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $webpage['Webpage']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $webpage['Webpage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $webpage['Webpage']['id'])); ?>
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
		<li><?php echo $html->link(__('New Webpage', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<?php
	$menu->setValue(array($html->link(__('Add Webpage', true), array('controller' => 'webpages', 'action' => 'add'), array('title' => 'Add Webpage', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;'))));
?>