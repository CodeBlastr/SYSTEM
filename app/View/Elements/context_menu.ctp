<?php
$menus = !empty($context_menu['menus']) ? $context_menu['menus'] : null;
if (!empty($menus)) {
	$menu = '';
	$menu = '<ul class="contextMenu actions">';
			foreach ($menus as $menugroup) :
				$menu .= '<li class="actionHeading"><span>'.$menugroup['heading'].'</span></a>';
					if (!empty($menugroup['items'])):
						foreach ($menugroup['items'] as $item) :
							$menu .= '<li class="actionItem">'.$item.'</li>';
						endforeach;
					endif;
				$menu .= '';
			endforeach;
	$menu .= '</ul>';
}
echo !empty($menu) ? $menu : null;
?>