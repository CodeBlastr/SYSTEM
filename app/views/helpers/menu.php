<?php

class MenuHelper extends AppHelper {
    var $value = '';

	
	function afterRender() {
		
		
        /*App::import('Component', 'Acl');
		$Acl = new AclComponent();
		App::import('Controller', 'AppController');
		$Controller = new AppController;
		
		
			#$aro = $Controller->_guestsAro(); // guests group aro model and foreign_key
			#$aco = $Controller->_getAcoPath(); // get controller and action 
			#debug($aro);
			#debug($aco);
			#break;
			# this first one checks record level if record level exists
			# which it can exist and guests could still have access 
			#if ($this->Acl->check($aro, $aco)) {
			#	$this->Auth->allow('*');
			#}*/
		
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