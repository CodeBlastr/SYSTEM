<?php

App::uses('ZuhaSchema', 'Model');
App::uses('SchemaShell', 'Console/Command');

/**
 * Schema is a command-line database management utility for automating programmer chores.
 *
 * Schema is CakePHP's database management utility. This helps you maintain versions of
 * of your database.
 *
 * @package       Zuha.Console.Command
 */
class ZuhaSchemaShell extends SchemaShell {



/**
 * Override startup
 *
 * @return void
 */
	public function startup() {
		$this->_welcome();
		$this->out('Cake Schema Shell');
		$this->hr();

		$name = $path = $connection = $plugin = null;
		if (!empty($this->params['name'])) {
			$name = $this->params['name'];
		} elseif (!empty($this->args[0]) && $this->args[0] !== 'snapshot') {
			$name = $this->params['name'] = $this->args[0];
		}

		if (strpos($name, '.')) {
			list($this->params['plugin'], $splitName) = pluginSplit($name);
			$name = $this->params['name'] = $splitName;
		}

		if ($name) {
			$this->params['file'] = Inflector::underscore($name);
		}

		if (empty($this->params['file'])) {
			$this->params['file'] = 'schema.php';
		}
		if (strpos($this->params['file'], '.php') === false) {
			$this->params['file'] .= '.php';
		}
		$file = $this->params['file'];

		if (!empty($this->params['path'])) {
			$path = $this->params['path'];
		}

		if (!empty($this->params['connection'])) {
			$connection = $this->params['connection'];
		}
		if (!empty($this->params['plugin'])) {
			$plugin = $this->params['plugin'];
			if (empty($name)) {
				$name = $plugin;
			}
		}
		$this->Schema = new ZuhaSchema(compact('name', 'path', 'file', 'connection', 'plugin'));
	}

}
