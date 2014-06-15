<?php
App::uses('AppModel', 'Model');

class Alias extends AppModel {

	public $name = 'Alias';
	
	public $validate = array(
		'name' => array(
			'notemptyRule' => array(
			   'rule' =>'notempty',
			   'message' => 'Permanent url must have a name.'
                ),
			'uniqueRule' => array(
			   'rule' =>'isUnique',
			   'message' => 'Permanent url must be unique.'
                ),
			'alphaNumericDashUnderscore' => array(
			   'rule' => '|^[0-9a-zA-Z\._/-]*$|',
			   'message' => 'Permanent url can only be letters, numbers, underscores, slashes, and periods.'
                )
            ),
        );
		
/**
 * beforeValidate callback
 * 
 * @param type $options
 * @return array
 */
	public function beforeValidate($options = array()) {
		$this->data = $this->cleanInputData($this->data);
		return parent::beforeValidate($options);
	}

/**
 * afterSave
 * 
 * Write out the routes.php file
 */
 	// public function afterSave($created, $options = array()) {
 		// $aliases = $this->find('all');
		// $routes = '';
		// foreach ($aliases as $alias) {
			// $alias['Alias']['name'] = $alias['Alias']['name'] == 'home' ? '' : $alias['Alias']['name']; // keyword home is the homepage
// 			
			// $plugin = !empty($alias['Alias']['plugin']) ? '/' . $alias['Alias']['plugin'] : null;
			// $controller = !empty($alias['Alias']['controller']) ? '/' . $alias['Alias']['controller'] : null;
			// $action = !empty($alias['Alias']['action']) ? '/' . $alias['Alias']['action'] : null;
			// $value = !empty($alias['Alias']['value']) ? '/' . $alias['Alias']['value'] : null;
			// $url = $plugin . $controller . $action . $value;
			// $routes .= 'Router::redirect(\'' . $url . '\', \'/' . $alias['Alias']['name'] . '\', array(\'status\' => 301));' . PHP_EOL;
			// $routes .= 'Router::connect(\'/' . $alias['Alias']['name'] . '\', array(\'plugin\' => \'' . $alias['Alias']['plugin'] . '\', \'controller\' => \'' . $alias['Alias']['controller'] . '\', \'action\' => \'' . $alias['Alias']['action'] . '\', \'' . implode('\', \'', explode('/', $alias['Alias']['value'])) . '\'));' . PHP_EOL;
		// }
// 
		// App::uses('File', 'Utility');
		// $file = new File(ROOT . DS . SITE_DIR . DS . 'Config' . DS . 'routes.php');
		// $currentRoutes = str_replace(array('<?php ', '<?php'), '', explode('// below this gets overwritten', $file->read()));
		// $routes = '<?php ' . $currentRoutes[0] . '// below this gets overwritten' . PHP_EOL . PHP_EOL . $routes;
		// if ($file->write($routes)) {
			// $file->close();
		// } else {
			// $file->close(); // Be sure to close the file when you're done
			// throw new Exception(__('Error writing routes file'));
		// }
		// // <?php
		// // Router::redirect('/webpages/webpages/view/113', '/lenovo', array('status' => 301));
		// // Router::connect('/lenovo', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'view', 113));
 	// }
	
/**
 * Clean Input Data
 * Before saving we need to check the data for consistency.
 *
 * @param array
 * @return array
 * @todo Clean out alias data for templates and elements.
 */
	public function cleanInputData($data) {
		if (empty($data['Alias']['name'])) {
			// remove the alias if the name is blank
			unset($data['Alias']);
		}
		return $data;
	}

/**
 * Sync all tables that have the alias field in them
 * 
 */
 	public function sync() {
 		$aliases = array();
 		$db = $this->getDataSource();
		foreach ($db->listSources() as $table) {
			foreach ($db->describe($table) as $column => $description) {
				if ($column == 'alias') {
					$aliases = array_merge($aliases, $this->find('all', array(
						'conditions' => array(
							'Alias.plugin' => ZuhaInflector::pluginize($table),
							'Alias.controller' => $table,
							'Alias.action' => 'view'
							)
						)));
				}
			}
		}
		if (!empty($aliases)) {
			foreach($aliases as $alias) {
				$query = __("UPDATE `%s` SET `alias` = '%s' WHERE `%s`.`id` = '%s';", $alias['Alias']['controller'], $alias['Alias']['name'], $alias['Alias']['controller'], $alias['Alias']['value']);
				$this->query($query);
				$return[] = $query;
			}
		}
		return $return;
 	}
	
/**
 * Get new alias method
 * 
 * @param mixed $name
 * @todo $name could also be an array in some future case I'm imagining
 */
	public function getNewAlias($name = null) {
        $names[] = ZuhaInflector::urlify($name);
        for($i = 0; $i < 10; $i++){
            $names[] = ZuhaInflector::urlify($name) . $i;
        }
		$alias = $this->find('count', array('conditions' => array('Alias.name' => $names)));
		if ($alias > 0) {
			return $names[0] . $alias;
		} else {
			return $names[0];
		}
	}
	
/**
 * Get Alias method
 * Finds existing alias and returns it if it exists (else returns a url ready string)
 * 
 * @param mixed $name
 * @return array 
 * @todo $name could also be an array in some future case I'm imagining
 */
	public function getAlias($name = null) {
		$alias = $this->find('first', array('conditions' => array('Alias.name' => ZuhaInflector::urlify($name))));
		if (!empty($alias)) {
			return array('old' => $alias['Alias']['name']);
		} else {
			return array('new' => ZuhaInflector::urlify($name));
		}
	}

}
