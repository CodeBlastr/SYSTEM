<?php
$menus = !empty($context_menu['menus']) ? $context_menu['menus'] : null;
if (!empty($menus) || !empty($before) || !empty($after)) {
	$menu = '<ul class="context_menu dropdown-menu">';
	$menu .= !empty($before) ? $before : null;
	if (!empty($menus)) {
		foreach ($menus as $menugroup) {
			$menu .= '<li class="nav-header">' . $menugroup['heading'] . '</li>';
			if (!empty($menugroup['items'])) {
				foreach ($menugroup['items'] as $item) {
					$menu .= '<li class="nav-item">' . $item . '</li>';
				}
			}
		}
	}
	$menu .= !empty($after) ? $after : null;
	$menu .= '</ul>';
}
echo !empty($menu) ? $menu : null;