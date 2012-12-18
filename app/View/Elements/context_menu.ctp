<?php
$menus = !empty($context_menu['menus']) ? $context_menu['menus'] : null;
$viewFile = !empty($_view) && $_view != $this->request->action ? $_view : 0;
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
    $menu .= '<li class="nav-header">Customize</li>';
    $menu .= '<li class="nav-item">' . $this->Html->link('Edit code', array('plugin' => 'webpages', 'controller' => 'file', 'action' => 'edit', $this->request->plugin, $this->request->controller, $this->request->action, implode('/', $this->request->params['pass']), 'view' => $viewFile)) . '</li>';
	$menu .= !empty($after) ? $after : null;
	$menu .= '</ul>';
}

echo !empty($menu) ? $menu : null;