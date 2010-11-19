<?php
/**
 * Attributes Element
 *
 * Displays the custom attributes fields and values for the add, edit, and view resource versions.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
?>
<div id="attributeForm">
<?php
$groups = $this->requestAction('attribute_groups/display/'.$plugin.'/'.$model.'/'.$type.'/'.$limiter);

foreach ($groups as $group) {
	$attributes[] = $group['Attribute'];
}

echo $form->create($model, array(
	'url' => strtolower($plugin).'/'.
			 Inflector::pluralize(Inflector::underscore($model)).'/'.
			 $type
	));

foreach ($attributes as $attribute) {
	foreach ($attribute as $attr) {
		echo $form->input($attr['code'], array(
					'label' => $attr['name'],
					)); 
	}
} 

echo $form->end('Submit');
?>
</div>