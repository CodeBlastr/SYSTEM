<?php
App::uses('CakeSchema', 'Model');

class ZuhaSchema extends CakeSchema {

/**
 * Override write function
 *
 * @param mixed $object schema object or options array
 * @param array $options schema object properties to override object
 * @return mixed false or string written to file
 */
	public function write($object, $options = array()) {
		if (is_object($object)) {
			$object = get_object_vars($object);
			$this->build($object);
		}

		if (is_array($object)) {
			$options = $object;
			unset($object);
		}
		extract(array_merge(
			get_object_vars($this), $options
		));
		
		$name = $name == 'Zuha' ? 'App' : $name; // CakeSchema was making this Zuha for some reason.
		$out = "class {$name}Schema extends CakeSchema {\n\n";

		if ($path !== $this->path) {
			$out .= "\tpublic \$path = '{$path}';\n\n";
		}

		if ($file !== $this->file) {
			$out .= "\tpublic \$file = '{$file}';\n\n";
		}

		if ($connection !== 'default') {
			$out .= "\tpublic \$connection = '{$connection}';\n\n";
		}
		
		$out .= $this->_getRenames($name); // get previous renamed columns
	
		$out .= "\tpublic function before(\$event = array()) {\n\t\tApp::uses('UpdateSchema', 'Model'); \n\t\t\$this->UpdateSchema = new UpdateSchema;\n\t\t\$before = \$this->UpdateSchema->before(\$event);\n\t\treturn \$before;\n\t}\n\n\tpublic function after(\$event = array()) {\n\t\t\$this->UpdateSchema->rename(\$event, \$this->renames);\n\t\t\$this->UpdateSchema->after(\$event);\n\t}\n\n";

		if (empty($tables)) {
			$this->read();
		}
		
		foreach ($tables as $table => $fields) {
			if (!is_numeric($table) && $table !== 'missing' && (!empty($this->plugin) && $table !== 'aros' && $table !== 'acos' && $table !== 'aros_acos')) {
				$out .= $this->generateTable($table, $fields);
			}
		}
		$out .= "}\n";

		$file = new File($path . DS . $file, true);
		$content = "<?php \n{$out}";
		if ($file->write($content)) {
			return $content;
		}
		return false;
	}
	
/**
 * Get the current renames to keep them when generated
 *
 * @param string
 * @return mixed
 */
	protected function _getRenames($name) {		
		$out = "\tpublic \$renames = array();\n\n";
		
		$out .= "\tpublic function __construct(\$options = array()) {\n";
		$out .= "\t\tparent::__construct();\n";
	
		$className = $name . 'Schema';
		@include($this->path . DS . $this->file);
		if (class_exists($className)) {
			$Schema = new $className();
			if (!empty($Schema->renames)) {
				$tables = $this->_generateRenames($Schema->renames);
				$out .= "\t\t\$this->renames = $tables";
			}
		}
		$out .= "\t}\n\n";
		
		return $out;		
	}
	
/**
 * Generate the renamed column arrays
 */
	protected function _generateRenames($fields) {
		$out = "array(\n";
		if (is_array($fields)) {
			$cols = array();
			foreach ($fields as $field => $value) {
				if ($field != 'indexes' && $field != 'tableParameters') {
					if (is_string($value)) {
						$type = $value;
						$value = array('type' => $type);
					}
					$col = "\t\t\t'{$field}' => array(";
					unset($value['type']);
					$col .= join(', ',  $this->_values($value));
				} elseif ($field == 'indexes') {
					$col = "\t\t'indexes' => array(";
					$props = array();
					foreach ((array)$value as $key => $index) {
						$props[] = "'{$key}' => array(" . join(', ',  $this->_values($index)) . ")";
					}
					$col .= join(', ', $props);
				} elseif ($field == 'tableParameters') {
					$col = "\t\t'tableParameters' => array(";
					$props = array();
					foreach ((array)$value as $key => $param) {
						$props[] = "'{$key}' => '$param'";
					}
					$col .= join(', ', $props);
				}
				$col .= ")";
				$cols[] = $col;
			}
			$out .= join(",\n", $cols);
		}
		$out .= "\n\t\t\t);\n";
		return $out;
	}

/**
 * Override read() to get rid of HABTM tables from polluting our schema files
 *
 * Options
 *
 * - 'connection' - the db connection to use
 * - 'name' - name of the schema
 * - 'models' - a list of models to use, or false to ignore models
 *
 * @param array $options schema object properties
 * @return array Array indexed by name and tables
 */
	public function read($options = array()) {
		extract(array_merge(
			array(
				'connection' => $this->connection,
				'name' => $this->name,
				'models' => true,
			),
			$options
		));
		$db = ConnectionManager::getDataSource($connection);

		if (isset($this->plugin)) {
			App::uses($this->plugin . 'AppModel', $this->plugin . '.Model');
		}

		$tables = array();
		$currentTables = (array)$db->listSources();

		$prefix = null;
		if (isset($db->config['prefix'])) {
			$prefix = $db->config['prefix'];
		}

		if (!is_array($models) && $models !== false) {
			if (isset($this->plugin)) {
				$models = App::objects($this->plugin . '.Model', null, false);
			} else {
				$models = App::objects('Model');
			}
		}

		if (is_array($models)) {
			foreach ($models as $model) {
				$importModel = $model;
				$plugin = null;
				if ($model == 'AppModel') {
					continue;
				}

				if (isset($this->plugin)) {
					if ($model == $this->plugin . 'AppModel') {
						continue;
					}
					$importModel = $model;
					$plugin = $this->plugin . '.';
				}

				App::uses($importModel, $plugin . 'Model');
				if (!class_exists($importModel)) {
					continue;
				}

				$vars = get_class_vars($model);
				if (empty($vars['useDbConfig']) || $vars['useDbConfig'] != $connection) {
					continue;
				}

				try {
					$Object = ClassRegistry::init(array('class' => $model, 'ds' => $connection));
				} catch (CakeException $e) {
					continue;
				}

				$db = $Object->getDataSource();
				if (is_object($Object) && $Object->useTable !== false) {
					$fulltable = $table = $db->fullTableName($Object, false, false);
					if ($prefix && strpos($table, $prefix) !== 0) {
						continue;
					}
					$table = $this->_noPrefixTable($prefix, $table);

					if (in_array($fulltable, $currentTables)) {
						$key = array_search($fulltable, $currentTables);
						if (empty($tables[$table])) {
							$tables[$table] = $this->_columns($Object);
							$tables[$table]['indexes'] = $db->index($Object);
							$tables[$table]['tableParameters'] = $db->readTableParameters($fulltable);
							unset($currentTables[$key]);
						}
						/*
						if (!empty($Object->hasAndBelongsToMany)) {
							foreach ($Object->hasAndBelongsToMany as $Assoc => $assocData) {
								if (isset($assocData['with'])) {
									$class = $assocData['with'];
								}
								if (is_object($Object->$class)) {
									$withTable = $db->fullTableName($Object->$class, false, false);
									if ($prefix && strpos($withTable, $prefix) !== 0) {
										continue;
									}
									if (in_array($withTable, $currentTables)) {
										$key = array_search($withTable, $currentTables);
										$noPrefixWith = $this->_noPrefixTable($prefix, $withTable);

										$tables[$noPrefixWith] = $this->_columns($Object->$class);
										$tables[$noPrefixWith]['indexes'] = $db->index($Object->$class);
										$tables[$noPrefixWith]['tableParameters'] = $db->readTableParameters($withTable);
										unset($currentTables[$key]);
									}
								}
							}
						}*/
					}
				}
			}
		}

		if (!empty($currentTables)) {
			foreach ($currentTables as $table) {
				if ($prefix) {
					if (strpos($table, $prefix) !== 0) {
						continue;
					}
					$table = $this->_noPrefixTable($prefix, $table);
				}
				$Object = new AppModel(array(
					'name' => Inflector::classify($table), 'table' => $table, 'ds' => $connection
				));

				$systemTables = array(
					'aros', 'acos', 'aros_acos', Configure::read('Session.table'), 'i18n'
				);

				$fulltable = $db->fullTableName($Object, false, false);

				if (in_array($table, $systemTables)) {
					$tables[$Object->table] = $this->_columns($Object);
					$tables[$Object->table]['indexes'] = $db->index($Object);
					$tables[$Object->table]['tableParameters'] = $db->readTableParameters($fulltable);
				} elseif ($models === false) {
					$tables[$table] = $this->_columns($Object);
					$tables[$table]['indexes'] = $db->index($Object);
					$tables[$table]['tableParameters'] = $db->readTableParameters($fulltable);
				} else {
					$tables['missing'][$table] = $this->_columns($Object);
					$tables['missing'][$table]['indexes'] = $db->index($Object);
					$tables['missing'][$table]['tableParameters'] = $db->readTableParameters($fulltable);
				}
			}
		}

		ksort($tables);
		return compact('name', 'tables');
	}
}
        