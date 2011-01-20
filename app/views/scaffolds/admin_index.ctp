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
<div class="indexContainer">
<div class="indexRow" id="headingRow">
<?php if (!empty($indexData[0][$modelClass])) : foreach ($indexData[0][$modelClass] as $_alias => $_field):?>
	<div class="indexCell columnHeading" id="<?php echo $_alias; ?>"><?php echo $paginator->sort($_alias);?></div>
<?php endforeach;?>
	<div class="indexCell columnHeading" id="columnActions"><?php __('Actions');?></div>
</div>
<?php
$i = 0;
foreach ($indexData as $_modelClass) :
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
echo "\n";
	echo "\t<div class=\"indexRow {$class}\">\n";
		foreach ($_modelClass[$modelClass] as $_alias => $_field) : 
			echo "\t\t<div class=\"indexCell\" id=\"{$_alias}\">\n\t\t\t{$_field}\n\t\t</div>\n";
		endforeach;

		echo "\t\t<div class=\"columnActions\">\n";
		echo "\t\t\t" . $html->link(__('View', true), array('action' => 'view',$_modelClass[$modelClass]['id'] )) . "\n";
	 	echo "\t\t\t" . $html->link(__('Edit', true), array('action' => 'edit', $_modelClass[$modelClass]['id'])) . "\n";
	 	echo "\t\t\t" . $html->link(__('Delete', true), array('action' => 'delete', $_modelClass[$modelClass]['id']), null, __('Are you sure you want to delete', true).' #' . $_modelClass[$modelClass]['id']) . "\n";
		echo "\t\t</div>\n";
	echo "\t</div>\n";
endforeach; else:
echo __('No records found.');
endif;
echo "\n";
?>
</div>
</div>

<?php echo $this->element('paging');?>

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




