<?php
$menus = !empty($context_menu['menus']) ? $context_menu['menus'] : null;
if (!empty($menus)) {
	$menu = '<ul class="nav navbar-nav navbar-right">';
	foreach ($menus as $menugroup) {
		if (!empty($menugroup['items'])) {
			foreach ($menugroup['items'] as $item) {
				$menu .= '<li>' . $item . '</li>';
			}
		}
	}
	$menu .= '</ul>';
}
echo !empty($menu) ? $menu : null;
