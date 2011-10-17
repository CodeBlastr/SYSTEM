<?php 
# setup view vars for reuse 
$modelClass = Inflector::classify($this->request->params['controller']); #ex. ContactPerson
$prefix = (!empty($this->params['prefix']) ? $this->params['prefix'] : null); #admin
$plugin = (!empty($this->request->params['plugin']) ? $this->request->params['plugin'] : null); #contacts
$controller = $this->request->params['controller']; #contact_people
$viewVar = Inflector::variable(Inflector::singularize($this->request->params['controller'])); #contactPerson
$humanModel = Inflector::humanize(Inflector::underscore($modelClass)); #Contact Person
$humanCtrl = Inflector::humanize(Inflector::underscore($controller)); #Contact People
$viewData = $___dataForView[$viewVar];
?>



<div class="<?php echo $viewVar;?> view" id="catalog<?php echo $this->params['pass'][0]; ?>">
  <h2><?php echo(!empty($settings['pageHeading']) ? ($settings['pageHeading'] != 1 ? $settings['pageHeading'] : $humanModel) : ''); ?></h2>

<?php
/**
 * Puts standardized variables from settings into a standardized view which is somewhat customizable.
 *
 * @todo		Make use of all of the text variables you can use, from cakephp as options.  http://book.cakephp.org/view/216/Text
 */
$i = 0;

foreach ($settings['fields'] as $alias => $_options):
	# set the variables that refer to models and fields.  config file may say, contain[] = Model.field or contain[] = field
	$_alias = (strpos($alias, '.') ? explode('.', $alias) : $alias);
	$_modelClass = (is_array($_alias) ? $_alias[0] : $modelClass);
	$_alias = (is_array($_alias) ? $_alias[1] : $_alias);
	
	# if the config has displayName = 1, then we use the field name, other wise we show displayName = {string}
	$displayName = (!empty($_options['option']['displayName']) ? ($_options['option']['displayName'] !== 1 ? $_options['option']['displayName'] : Inflector::humanize($_alias)) : '');
	
	# display the content for this field, with optional truncation (more options to be added)
	$displayContent = (!empty($_options['option']['truncate']) ? $text->truncate($viewData[$_modelClass][$_alias], $_options['option']['truncate'], array('ending' => '...', 'exact' => false, 'html' => true)) : $viewData[$_modelClass][$_alias]);

	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
	echo "<div id=\"view{$_alias}{$viewData[$modelClass]['id']}\" class=\"viewRow {$_alias} {$class}\">";
		echo "\t\t<div id=\"viewName{$_alias}\" class=\"viewCell name {$class}\">" . $displayName . "</div>\n";
		echo "\t\t<div id=\"viewContent{$_alias}\" class=\"viewCell content {$class}\">\n\t\t\t". $displayContent ."\n&nbsp;\t\t</div>\n";
	echo "</div>";
endforeach;

# show the gallery if it exists (in the config you would need to have a setting for contain[] = Gallery
echo !empty($viewData['Gallery']['id']) ? $this->element($viewData['Gallery']['type'], array('id' => $viewData['Gallery']['id'], 'plugin' => 'galleries')) : null;
?>

</div>
<?php /*
<div class="actions">
	<ul>
	$menuItems[0]['heading'] = $pluralHumanName;
	$menuItems[0]['items'][] = $this->Html->link(sprintf(__('Edit %s', true), $singularHumanName),   array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]));
	$menuItems[0]['items'][] = $this->Html->link(sprintf(__('Delete %s', true), $singularHumanName), array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), null, __('Are you sure you want to delete', true).' #' . ${$singularVar}[$modelClass][$primaryKey] . '?');
	$menuItems[0]['items'][] = $this->Html->link(sprintf(__('List %s', true), $pluralHumanName), array('action' => 'index'));
	$menuItems[0]['items'][] = $this->Html->link(sprintf(__('New %s', true), $singularHumanName), array('action' => 'add'));

	$done = array();
	$menuItems[1]['heading'] = 'Related'; 
	foreach ($associations as $_type => $_data) {
		foreach ($_data as $_alias => $_details) {
			if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
				$menuItems[1]['items'][] = $this->Html->link(sprintf(__('List %s', true), Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index'));
				$menuItems[1]['items'][] = $this->Html->link(sprintf(__('New %s', true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'));
				$done[] = $_details['controller'];
			}
		}
	}
	</ul>
</div>
?>
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
	<?php $menuItems[0]['items'][] = $this->Html->link(sprintf(__('Edit %s', true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'edit', ${$singularVar}[$_alias][$_details['primaryKey']]));?>
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
			echo "\t\t\t\t" . $this->Html->link(__('View', true), array('controller' => $_details['controller'], 'action' => 'view', ${$otherSingularVar}[$_details['primaryKey']])). "\n";
			echo "\t\t\t\t" . $this->Html->link(__('Edit', true), array('controller' => $_details['controller'], 'action' => 'edit', ${$otherSingularVar}[$_details['primaryKey']])). "\n";
			echo "\t\t\t\t" . $this->Html->link(__('Delete', true), array('controller' => $_details['controller'], 'action' => 'delete', ${$otherSingularVar}[$_details['primaryKey']]), null, __('Are you sure you want to delete', true).' #' . ${$otherSingularVar}[$_details['primaryKey']] . '?'). "\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";
		endforeach;
?>
	</table>
<?php endif; ?>
	<?php $menuItems[2]['heading'] = 'New Related'; ?>
	<?php $menuItems[2]['items'][] = $this->Html->link(sprintf(__("New %s", true), Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add'));?> 
</div>
<?php endforeach;?>

<?php 
		
// set the contextual menu items
$this->Menu->setValue($menuItems);
*/ ?>






