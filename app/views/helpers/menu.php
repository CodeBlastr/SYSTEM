<?php

class MenuHelper extends AppHelper {
    var $value = '';

    function afterRender() {
		if (!empty($this->value)) {
			$menu = '';
			$menu = '
             	<div id="col2">
					<h2><span class="punch">Contextual</span> Nav</h2><div id="accordion">';
				foreach ($this->value as $menugroup) :
					$menu .= '<div><h3><a href="#">'.$menugroup['heading'].'</a></h3>';
						if (!empty($menugroup['items'])):
							$menu .= '<div><ul>';
							foreach ($menugroup['items'] as $item) :
								$menu .= '<li>'.$item.'</li>';
							endforeach;
							$menu.= '</ul></div>';
						endif;
					$menu .= '</div>';
				endforeach;
			$menu .= '</div></div>';
		}
		
		
		/*
		if (is_array($this->value)) {
			$menuitems .= '<div id="accordion">';
			foreach ($this->value as $value) {
				if(is_array($value)){
					$menuitems .= '<li id="'.$value['itemid'].'" style="'.$value['style'].'">'.$value['item'].'</li>';
				} else {
					$menuitems .= '<li>'.$value.'</li>';
				}
			}
			$menuitems .= '</div>';
		}
		*/
		
		
		if (!empty($menu)) {
       	   $view = ClassRegistry::getObject('view');
	       $view->set('menu_for_layout', $menu);
		} else { 
       	   $view = ClassRegistry::getObject('view');
	       $view->set('menu_for_layout', '');
		}
    }

    function setValue($value) {
        $this->value = $value;
    }
}
?>