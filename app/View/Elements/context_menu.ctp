<?php
$menus = !empty($context_menu['menus']) ? $context_menu['menus'] : null;
if (!empty($menus)) {
	$menu = '<ul class="context_menu dropdown-menu">';
	foreach ($menus as $menugroup) {
		//$menu .= '<label>' . $menugroup['heading'] . '</label>';
		if (!empty($menugroup['items'])) {
			foreach ($menugroup['items'] as $item) {
				$menu .= '<li>' . $item . '</li>';
			}
		}
	}
	$menu .= '</ul>';
}
echo !empty($menu) ? $menu : null;