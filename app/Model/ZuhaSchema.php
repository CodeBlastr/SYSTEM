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
	
		$out .= "\tpublic function before(\$event = array()) {\n\t\tApp::uses('UpdateSchema', 'Model'); \n\t\t\$this->UpdateSchema = new UpdateSchema;\n\t\t\$before = \$this->UpdateSchema->before(\$event);\n\t\treturn \$before;\n\t}\n\n\tpublic function after(\$event = array()) {\n\t\t\$this->UpdateSchema->rename(\$event, \$this->renames);\n\t\t\$this->UpdateSchema->after(\$event);\n\t}\n\n";

		if (empty($tables)) {
			$this->read();
		}

		foreach ($tables as $table => $fields) {
			if (!is_numeric($table) && $table !== 'missing') {
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
}
        