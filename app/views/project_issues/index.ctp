<div class="projectIssues index">
<h2><?php __('ProjectIssues');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('contact_activity_type_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('project_id');?></th>
	<th><?php echo $paginator->sort('creator_id');?></th>
	<th><?php echo $paginator->sort('modifier_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($projectIssues as $projectIssue):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $projectIssue['ProjectIssue']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($projectIssue['ProjectIssueParent']['name'], array('controller' => 'project_issues', 'action' => 'view', $projectIssue['ProjectIssueParent']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($projectIssue['ProjectStatusType']['name'], array('controller' => 'contact_activity_types', 'action' => 'view', $projectIssue['ProjectStatusType']['id'])); ?>
		</td>
		<td>
			<?php echo $projectIssue['ProjectIssue']['name']; ?>
		</td>
		<td>
			<?php echo $projectIssue['ProjectIssue']['description']; ?>
		</td>
		<td>
			<?php echo $html->link($projectIssue['Project']['id'], array('controller' => 'projects', 'action' => 'view', $projectIssue['Project']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($projectIssue['Creator']['id'], array('controller' => 'users', 'action' => 'view', $projectIssue['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $projectIssue['ProjectIssue']['modifier_id']; ?>
		</td>
		<td>
			<?php echo $projectIssue['ProjectIssue']['created']; ?>
		</td>
		<td>
			<?php echo $projectIssue['ProjectIssue']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $projectIssue['ProjectIssue']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $projectIssue['ProjectIssue']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $projectIssue['ProjectIssue']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $projectIssue['ProjectIssue']['id'])); ?>
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
		<li><?php echo $html->link(__('New ProjectIssue', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Project Issues', true), array('controller' => 'project_issues', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Parent', true), array('controller' => 'project_issues', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue Types', true), array('controller' => 'contact_activity_types', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Type', true), array('controller' => 'contact_activity_types', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Projects', true), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue Media', true), array('controller' => 'contact_activity_media', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue Medium', true), array('controller' => 'contact_activity_media', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Project Issue User Groups', true), array('controller' => 'contact_activity_user_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project Issue User Group', true), array('controller' => 'contact_activity_user_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
