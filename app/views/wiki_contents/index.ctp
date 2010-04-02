<div class="wikiContents index">
<h2><?php __('WikiContents');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('text');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th><?php echo $paginator->sort('version');?></th>
	<th><?php echo $paginator->sort('wiki_page_id');?></th>
	<th><?php echo $paginator->sort('creator_id');?></th>
	<th><?php echo $paginator->sort('modifier_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($wikiContents as $wikiContent):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $wikiContent['WikiContent']['id']; ?>
		</td>
		<td>
			<?php echo $wikiContent['WikiContent']['text']; ?>
		</td>
		<td>
			<?php echo $wikiContent['WikiContent']['comments']; ?>
		</td>
		<td>
			<?php echo $wikiContent['WikiContent']['version']; ?>
		</td>
		<td>
			<?php echo $html->link($wikiContent['WikiPage']['title'], array('controller' => 'wiki_pages', 'action' => 'view', $wikiContent['WikiPage']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($wikiContent['Creator']['username'], array('controller' => 'users', 'action' => 'view', $wikiContent['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($wikiContent['Modifier']['username'], array('controller' => 'users', 'action' => 'view', $wikiContent['Modifier']['id'])); ?>
		</td>
		<td>
			<?php echo $wikiContent['WikiContent']['created']; ?>
		</td>
		<td>
			<?php echo $wikiContent['WikiContent']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $wikiContent['WikiContent']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $wikiContent['WikiContent']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $wikiContent['WikiContent']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wikiContent['WikiContent']['id'])); ?>
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
		<li><?php echo $html->link(__('New WikiContent', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Wiki Pages', true), array('controller' => 'wiki_pages', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Wiki Page', true), array('controller' => 'wiki_pages', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
