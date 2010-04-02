<?php

class MenuHelper extends AppHelper {
    var $value = '';

    function afterRender() {
        $view = ClassRegistry::getObject('view');
		$menuitems = '';
		if (is_array($this->value)) {
			foreach ($this->value as $value) {
				if(is_array($value)){
					$menuitems .= '<li id="'.$value['itemid'].'" style="'.$value['style'].'">'.$value['item'].'</li>';
				} else {
					$menuitems .= '<li>'.$value.'</li>';
				}
			}		
		}
		if (!empty($menuitems)) {
	       $view->set('menu_for_layout', $menuitems);
		}
    }

    function setValue($value) {
        $this->value = $value;
    }
}

?>