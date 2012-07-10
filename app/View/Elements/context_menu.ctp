<?php
$menus = !empty($context_menu['menus']) ? $context_menu['menus'] : null;
if (!empty($menus)) {
	$menu = '<ul data-role="listview"><li>';
	foreach ($menus as $menugroup) {
		$menu .= '<div data-role="controlgroup" data-type="horizontal">';
		//$menu .= '<label>' . $menugroup['heading'] . '</label>';
		if (!empty($menugroup['items'])) {
			foreach ($menugroup['items'] as $item) {
				$menu .= str_replace('<a', '<a data-role="button"', $item);
			}
		}
		$menu .= '</div>';
	}
	$menu .= '</li></ul>';
}
echo !empty($menu) ? $menu : null;