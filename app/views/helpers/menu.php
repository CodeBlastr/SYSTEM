<?php

class MenuHelper extends AppHelper {
    var $value = '';

    function afterRender() {
		if (!empty($this->value)) {
			$menu = '';
			$menu = '
             	<ul class="menu">
					<li class="drop-holder">';
				foreach ($this->value as $menugroup) :
					$menu .= '<li class="drop-holder"><a href="#"><span>'.$menugroup['heading'].'</span></a>';
						if (!empty($menugroup['items'])):
							$menu .= '<ul class="drop">';
							foreach ($menugroup['items'] as $item) :
								$menu .= '<li>'.$item.'</li>';
							endforeach;
							$menu.= '</ul>';
						endif;
					$menu .= '';
				endforeach;
			$menu .= '</li></ul>';
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