<?php
if (!empty($menus)) {
	$menu = '';
	$menu = '
      	<div class="contextMenu actions">
			<ul>';
			foreach ($menus as $menugroup) :
				$menu .= '<li class="actionHeading"><span>'.$menugroup['heading'].'</span></a>';
					if (!empty($menugroup['items'])):
						foreach ($menugroup['items'] as $item) :
							$menu .= '<li class="actionItem">'.$item.'</li>';
						endforeach;
					endif;
				$menu .= '';
			endforeach;
	$menu .= '</ul></div>';
}
echo $menu;
?>