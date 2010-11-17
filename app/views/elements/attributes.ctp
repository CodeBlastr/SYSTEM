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
foreach ($attributes as $attribute) {
	echo $form->input($attribute['Attribute']['code'], array(
				'label' => $attribute['Attribute']['name']
				)); 
} 
?>
</div>