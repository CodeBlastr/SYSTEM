<?php
$menus = !empty($context_menu['menus']) ? $context_menu['menus'] : null;
if (!empty($menus)) {
	$menu = '<li class="dropdown">';
	foreach ($menus as $menugroup) {
		$menu .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $menugroup['heading'] . '<b class="caret"></b></a><ul class="dropdown-menu">';
		if (!empty($menugroup['items'])) {
			foreach ($menugroup['items'] as $item) {
				$menu .= '<li>' . $item . '</li>';
			}
		}
		$menu .= '</ul>';
	}
	$menu .= '</li>';
}
echo !empty($menu) ? $menu : null;
