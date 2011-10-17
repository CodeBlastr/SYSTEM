<?php
class ControllerListComponent extends Object {
    function get() {
		$plugins = Configure::listObjects('plugin');
      	//Find plugin controller methods
    	if(!empty($plugins)) {
        	foreach($plugins as $p) {
	            $paths[] = ROOT . DS . APP_DIR . DS . 'plugins' . DS . strtolower($p) . DS . 'controllers';
	        }
	  	}
        $paths[] = ROOT . DS . APP_DIR . DS . 'controllers';
		
		
      	$controllerClasses = Configure::listObjects('controller', $paths); 
        $paths = array();
        $includePaths = explode(':', ini_get('include_path'));
        ini_set('include_path', implode(':', array_merge(array_diff($paths, $includePaths), $includePaths)));
        foreach($controllerClasses as $controller) {
            if ($controller != 'App') {
                $fileName = Inflector::underscore($controller);
                //include_once($fileName);
                $className = $fileName;
				if($className != "pages")
				{
					$classes[$className] = $className;
				}
            }
        }
        return $classes;
    }
}
?>