<?php
class MenuHelper extends AppHelper {
	
    var $value = '';
	
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$View->set('menu_for_layout', $this->display());
	}
	
	public function display() {
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
       	   #$view = ClassRegistry::getObject('view');
	      # $this->set('menu_for_layout', $menu);
		   return $menu;
		} else { 
       	   #$view = ClassRegistry::getObject('view');
	       return;
		}
    }


    public function setValue($value) {
        $this->value = $value;
    }
}
?>