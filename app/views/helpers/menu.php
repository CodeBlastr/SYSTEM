<?php
class MenuHelper extends AppHelper {
	
    var $value = '';
	
	function afterRender() {
				
		if (!empty($this->value)) {
			$menu = '';
			$menu = '
             	<div class="actions">
					<ul>';
				foreach ($this->value as $menugroup) :
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