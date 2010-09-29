<?php # setup standards for reuse 
	$model = Inflector::camelize($model); #ContactPerson
	$controller = Inflector::pluralize(Inflector::underscore($model)); #contact_people
	$human_model = Inflector::humanize(Inflector::underscore($model)); #Contact Person
	$human_ctrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
	# Inflector::singularize(Inflector::underscore($model)); #contact_person
	# Inflector::variable(Inflector::pluralize($model)); #contactPeople
?>
<div class="<?php echo $controller; ?> index">
<h2><?php __($human_ctrl);?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
<?php foreach($viewFields as $viewField) : ?>
	<?php if ($viewField == 'actions') : ?>
	<th class="actions"><?php __('Actions');?></th>
	<?php else: ?> 
	<th><?php echo $paginator->sort($viewField);?></th>
	<?php endif; ?>
<?php endforeach; ?>
</tr>
<?php
$i = 0;
foreach ($ctrl_vars as $ctrl_var):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?> id="row<?php echo $ctrl_var[$model]['id']; ?>">
	<?php foreach($viewFields as $viewField) : ?>
		<?php if ($viewField == 'actions') : ?>
		<td class="actions">
			<?php echo $ajax->link('Delete', array('controller' => $controller, 'action' => 'ajax_delete', $ctrl_var[$model]['id']), array('indicator' => 'loadingimg', 'update' => 'row'.$ctrl_var[$model]['id'], 'complete' => 'Effect.Fade(\'deleteMessage\', { duration: 2.0 });'), 'Permanently Delete... Are You Sure?'); ?>
		</td>
		<?php elseif ($viewField == 'created' || $viewField == 'modified' || $viewField == 'start_date' || $viewField == 'due_date') : ?>
		<td>
			<?php echo $time->nice($ctrl_var[$model][$viewField]); ?>
		</td>
		<?php else : ?>
		<td>
			<?php echo $html->link($ctrl_var[$model][$viewField], array('controller' => $controller, 'action' => 'view', $ctrl_var[$model]['id'])); ?> 
		</td>
		<?php endif; ?>
	<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>


<?php 
$menu->setValue(array($html->link(__('New '.$human_model, true), '/admin/'.$controller.'/edit', array('title' => $human_model, 'onclick' => 'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')))); 
?>
