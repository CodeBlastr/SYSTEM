<?php
class PluginListComponent extends Object {
    function get() {
        $paths = array();
        $controllerClasses = Configure::listObjects('plugin', $paths);
        $includePaths = explode(':', ini_get('include_path'));
        ini_set('include_path', implode(':', array_merge(array_diff($paths, $includePaths), $includePaths)));
        foreach($controllerClasses as $controller) {
            if ($controller != 'App') {
                $fileName = Inflector::underscore($controller);
                //include_once($fileName);
                $className = $fileName;
				if($className != "PagesController")
				{
					$classes[$className] = $className;
				}
            }
        }
        return $classes;
    }
}
?>