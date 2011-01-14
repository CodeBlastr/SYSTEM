<?php 
	# setup standards for reuse 
	$modelClass = Inflector::classify($this->params['controller']); #ex. ContactPerson
	$controller = $this->params['controller']; #contact_people
	$indexVar = Inflector::variable($this->params['controller']); #contactPerson
	$humanModel = Inflector::humanize(Inflector::underscore($modelClass)); #Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
	# Inflector::singularize(Inflector::underscore($model)); #contact_person
	# Inflector::variable(Inflector::pluralize($model)); #contactPeople
	$indexData = $___dataForView[$indexVar];
?>
<div class="<?php echo $indexVar;?> index">
<h2><?php echo $humanCtrl;?></h2>
<p><?php
echo $paginator->counter(array(
	'format' => 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
<?php foreach ($indexData[0][$modelClass] as $_alias => $_field):?>
	<th><?php echo $paginator->sort($_alias);?></th>
<?php endforeach;?>
	<th><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($indexData as $_modelClass) :
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
echo "\n";
	echo "\t<tr{$class}>\n";
		foreach ($_modelClass[$modelClass] as $_alias => $_field) : 
			echo "\t\t<td>\n\t\t\t" . $_field . " \n\t\t</td>\n";
		endforeach;

		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t" . $html->link(__('View', true), array('action' => 'view',$_modelClass[$modelClass]['id'] )) . "\n";
	 	echo "\t\t\t" . $html->link(__('Edit', true), array('action' => 'edit', $_modelClass[$modelClass]['id'])) . "\n";
	 	echo "\t\t\t" . $html->link(__('Delete', true), array('action' => 'delete', $_modelClass[$modelClass]['id']), null, __('Are you sure you want to delete', true).' #' . $_modelClass[$modelClass]['id']) . "\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";
endforeach;
echo "\n";
?>
</table>
</div>
<div class="paging">
<?php echo "\t" . $paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')) . "\n";?>
 | <?php echo $paginator->numbers() . "\n"?>
<?php echo "\t ". $paginator->next(__('next', true) .' >>', array(), null, array('class' => 'disabled')) . "\n";?>
</div>

<?php /*
$menuItems[] = $html->link('New '.$singularHumanName, array('action' => 'add'));

$done = array();
foreach ($associations as $_type => $_data) {
	foreach ($_data as $_alias => $_details) {
		if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
			$menuItems[] = $html->link(sprintf(__('List %s', true), Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index'));
			$menuItems[] = $html->link(sprintf(__('New %s', true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'));
			$done[] = $_details['controller'];
		}
	}
}
		
// set the contextual menu items
$menu->setValue(
	array(
		array(
			'heading' => $singularHumanName,
			'items' => $menuItems
		),
	)
); */
?>




