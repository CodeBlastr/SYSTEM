<?php # setup standards for reuse 
	$model = Inflector::classify($this->params['controller']); #ContactPerson
	$controller = $this->params['controller']; #contact_people
	$viewVar = Inflector::variable(Inflector::singularize($this->params['controller'])); #contactPerson
	$humanModel = Inflector::humanize(Inflector::underscore($model)); #Contact Person
	$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
	# Inflector::singularize(Inflector::underscore($model)); #contact_person
	# Inflector::variable(Inflector::pluralize($model)); #contactPeople
?>
<div class="<?php echo $pluralVar;?> view">
<h2><?php echo sprintf(__("View %s", true), $singularHumanName);?></h2>
	<dl>
<?php
$i = 0;
foreach ($scaffoldFields as $_field) {
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $_alias => $_details) {
			if ($_field === $_details['foreignKey']) {
				$isKey = true;
				echo "\t\t<dt{$class}>" . Inflector::humanize($_alias) . "</dt>\n";
				echo "\t\t<dd{$class}>\n\t\t\t" . $html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "\n\t\t&nbsp;</dd>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t<dt{$class}>" . Inflector::humanize($_field) . "</dt>\n";
		echo "\t\t<dd{$class}>\n\t\t\t{${$singularVar}[$modelClass][$_field]}\n&nbsp;\t\t</dd>\n";
	}
}
?>
	</dl>
</div>
<div class="actions">
	<ul>
<?php
	$menuItems[0]['heading'] = $pluralHumanName;
	$menuItems[0]['items'][] = $html->link(sprintf(__('Edit %s', true), $singularHumanName),   array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]));
	$menuItems[0]['items'][] = $html->link(sprintf(__('Delete %s', true), $singularHumanName), array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), null, __('Are you sure you want to delete', true).' #' . ${$singularVar}[$modelClass][$primaryKey] . '?');
	$menuItems[0]['items'][] = $html->link(sprintf(__('List %s', true), $pluralHumanName), array('action' => 'index'));
	$menuItems[0]['items'][] = $html->link(sprintf(__('New %s', true), $singularHumanName), array('action' => 'add'));

	$done = array();
	$menuItems[1]['heading'] = 'Related';
	foreach ($associations as $_type => $_data) {
		foreach ($_data as $_alias => $_details) {
			if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
				$menuItems[1]['items'][] = $html->link(sprintf(__('List %s', true), Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index'));
				$menuItems[1]['items'][] = $html->link(sprintf(__('New %s', true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'));
				$done[] = $_details['controller'];
			}
		}
	}
?>
	</ul>
</div>
<?php
if (!empty($associations['hasOne'])) :
foreach ($associations['hasOne'] as $_alias => $_details): ?>
<div class="related">
	<h3><?php echo sprintf(__("Related %s", true), Inflector::humanize($_details['controller']));?></h3>
<?php if (!empty(${$singularVar}[$_alias])):?>
	<dl>
<?php
		$i = 0;
		$otherFields = array_keys(${$singularVar}[$_alias]);
		foreach ($otherFields as $_field) {
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			echo "\t\t<dt{$class}>" . Inflector::humanize($_field) . "</dt>\n";
			echo "\t\t<dd{$class}>\n\t" . ${$singularVar}[$_alias][$_field] . "\n&nbsp;</dd>\n";
		}
?>
	</dl>
<?php endif; ?>
	<?php $menuItems[0]['items'][] = $html->link(sprintf(__('Edit %s', true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'edit', ${$singularVar}[$_alias][$_details['primaryKey']]));?>
</div>
<?php
endforeach;
endif;

if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $_alias => $_details):
$otherSingularVar = Inflector::variable($_alias);
?>
<div class="related">
	<h3><?php echo sprintf(__("Related %s", true), Inflector::humanize($_details['controller']));?></h3>
<?php if (!empty(${$singularVar}[$_alias])):?>
	<table cellpadding="0" cellspacing="0">
	<tr>
<?php
		$otherFields = array_keys(${$singularVar}[$_alias][0]);
		foreach ($otherFields as $_field) {
			echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
		}
?>
		<th class="actions">Actions</th>
	</tr>
<?php
		$i = 0;
		foreach (${$singularVar}[$_alias] as ${$otherSingularVar}):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		echo "\t\t<tr{$class}>\n";

			foreach ($otherFields as $_field) {
				echo "\t\t\t<td>" . ${$otherSingularVar}[$_field] . "</td>\n";
			}

			echo "\t\t\t<td class=\"actions\">\n";
			echo "\t\t\t\t" . $html->link(__('View', true), array('controller' => $_details['controller'], 'action' => 'view', ${$otherSingularVar}[$_details['primaryKey']])). "\n";
			echo "\t\t\t\t" . $html->link(__('Edit', true), array('controller' => $_details['controller'], 'action' => 'edit', ${$otherSingularVar}[$_details['primaryKey']])). "\n";
			echo "\t\t\t\t" . $html->link(__('Delete', true), array('controller' => $_details['controller'], 'action' => 'delete', ${$otherSingularVar}[$_details['primaryKey']]), null, __('Are you sure you want to delete', true).' #' . ${$otherSingularVar}[$_details['primaryKey']] . '?'). "\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";
		endforeach;
?>
	</table>
<?php endif; ?>
	<?php $menuItems[2]['heading'] = 'New Related'; ?>
	<?php $menuItems[2]['items'][] = $html->link(sprintf(__("New %s", true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'));?> 
</div>
<?php endforeach;?>

<?php 
		
// set the contextual menu items
$menu->setValue($menuItems);
?>






