<div class="projects index">
<h2><?php __('Projects');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('Contact.ContactPerson.last_name');?></th>
	<th><?php echo $paginator->sort('Contact.ContactCompany.name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($projects as $project):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?> id="row<?php echo $project['Project']['id']; ?>">
		<td>
			<?php echo $html->link(__($project['Project']['name'], true), array('action' => 'view', $project['Project']['id'])); ?>
		</td>
		<td>
			<?php if (!empty($project['Contact']['ContactPerson']['id'])) : echo $html->link(__($project['Contact']['ContactPerson']['first_name'].' '.$project['Contact']['ContactPerson']['last_name'], true), array('controller' => 'contact_people', 'action' => 'view', $project['Contact']['ContactPerson']['id'])); endif; ?>
		</td>
		<td>
			<?php if (!empty($project['Contact']['ContactCompany']['id'])) : echo $html->link(__($project['Contact']['ContactCompany']['name'], true), array('controller' => 'contact_companies', 'action' => 'view', $project['Contact']['ContactCompany']['id'])); endif; ?>
		</td>
		<td class="actions">
			<?php echo $ajax->link('Delete', array('controller' => 'projects', 'action' => 'ajax_delete', $project['Project']['id']), array('indicator' => 'loadingimg', 'update' => 'row'.$project['Project']['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Permanently Delete... Are You Sure?'); ?>
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
$menu->setValue(array($html->link(__('Add Project', true), array('controller' => 'projects', 'action' => 'edit'), array('title' => 'Add Project', 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>