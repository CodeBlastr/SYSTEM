<?php
/**
 * Cake form helper is the core form helper that comes in the lib/Cake/View/Helper/FormHelper.php file by default.
 * It has been copied to our app view directory in order to allow for partial overwrite instead of a full over write. 
 */
App::uses('CakeFormHelper', 'View/Helper');

/**
 * Form helper library.
 *
 * Automatic generation of HTML FORMs from given data.
 */
class FormHelper extends CakeFormHelper {

/**
 * Copies the validationErrors variable from the View object into this instance
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		$this->View = $View;
		parent::__construct($View, $settings);
	}
	
	public function select($fieldName, $options = array(), $attributes = array()) {
		// Added by Zuha to parse extra fields needed for ajax
		if (isset($attributes['ajax'])) {
			$attributes = $this->ajaxElement($attributes);
		}
		return parent::select($fieldName, $options, $attributes);
	}
	
	
	public function end($options = null) {
		if (!is_array($options)) {
			$label = !empty($options) ? $options : 'Submit';
			$options = array('label' => $options, 'before' => '<div data-role="fieldcontain"><label class="ui-input-text"></label>', 'after' => '</div>', 'data-theme' => 'b'); // Zuha for submit button formatting
		}
		return parent::end($options);
	}
	
/**
 * Overwrite the default input() function to make date fields use javascript date pickers by default
 */
	public function input($fieldName, $options = array()) {
		$this->setEntity($fieldName);

		$options = array_merge(
			array('before' => null, 'between' => null, 'after' => null, 'format' => null),
			$this->_inputDefaults,
			$options
		);

		$modelKey = $this->model();
		$fieldKey = $this->field();

		if (!isset($options['type'])) {
			$magicType = true;
			$options['type'] = 'text';
			if (isset($options['options'])) {
				$options['type'] = 'select';
			} elseif (in_array($fieldKey, array('psword', 'passwd', 'password'))) {
				$options['type'] = 'password';
			} elseif (isset($options['checked'])) {
				$options['type'] = 'checkbox';
			} elseif ($fieldDef = $this->_introspectModel($modelKey, 'fields', $fieldKey)) {
				$type = $fieldDef['type'];
				$primaryKey = $this->fieldset[$modelKey]['key'];
			}

			if (isset($type)) {
				$map = array(
					'string' => 'text', 'datetime' => 'datetime',
					'boolean' => 'checkbox', 'timestamp' => 'datetime',
					'text' => 'textarea', 'time' => 'time',
					'date' => 'date', 'float' => 'number',
					'integer' => 'number'
				);

				if (isset($this->map[$type])) {
					$options['type'] = $this->map[$type];
				} elseif (isset($map[$type])) {
					$options['type'] = $map[$type];
				}
				if ($fieldKey == $primaryKey) {
					$options['type'] = 'hidden';
				}
				if (
					$options['type'] === 'number' &&
					$type === 'float' &&
					!isset($options['step'])
				) {
					$options['step'] = 'any';
				}
			}
			if (preg_match('/_id$/', $fieldKey) && $options['type'] !== 'hidden') {
				$options['type'] = 'select';
			}

			if ($modelKey === $fieldKey) {
				$options['type'] = 'select';
				if (!isset($options['multiple'])) {
					$options['multiple'] = 'multiple';
				}
			}
		}
		$types = array('checkbox', 'radio', 'select');

		if (
			(!isset($options['options']) && in_array($options['type'], $types)) ||
			(isset($magicType) && $options['type'] == 'text')
		) {
			$varName = Inflector::variable(
				Inflector::pluralize(preg_replace('/_id$/', '', $fieldKey))
			);
			$varOptions = $this->_View->getVar($varName);
			if (is_array($varOptions)) {
				if ($options['type'] !== 'radio') {
					$options['type'] = 'select';
				}
				$options['options'] = $varOptions;
			}
		}

		$autoLength = (!array_key_exists('maxlength', $options) && isset($fieldDef['length']));
		if ($autoLength && $options['type'] == 'text') {
			$options['maxlength'] = $fieldDef['length'];
		}
		if ($autoLength && $fieldDef['type'] == 'float') {
			$options['maxlength'] = array_sum(explode(',', $fieldDef['length'])) + 1;
		}

		$divOptions = array();
		$div = $this->_extractOption('div', $options, true);
		unset($options['div']);

		if (!empty($div)) {
			$divOptions['class'] = 'input';
			$divOptions['data-role'] = 'fieldcontain'; // Zuha added for jquery mobile form elements
			$divOptions = $this->addClass($divOptions, $options['type']);
			if (is_string($div)) {
				$divOptions['class'] = $div;
			} elseif (is_array($div)) {
				$divOptions = array_merge($divOptions, $div);
			}
			if ($this->_introspectModel($modelKey, 'validates', $fieldKey)) {
				$divOptions = $this->addClass($divOptions, 'required');
			}
			if (!isset($divOptions['tag'])) {
				$divOptions['tag'] = 'div';
			}
		}

		$label = null;
		if (isset($options['label']) && $options['type'] !== 'radio') {
			$label = $options['label'];
			unset($options['label']);
		}

		if ($options['type'] === 'radio') {
			$label = false;
			if (isset($options['options'])) {
				$radioOptions = (array)$options['options'];
				unset($options['options']);
			}
		}

		if ($label !== false) {
			$label = $this->_inputLabel($fieldName, $label, $options);
		}

		$error = $this->_extractOption('error', $options, null);
		unset($options['error']);

		$selected = $this->_extractOption('selected', $options, null);
		unset($options['selected']);

		if (isset($options['rows']) || isset($options['cols'])) {
			$options['type'] = 'textarea';
		}

		if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time' || $options['type'] === 'select') {
			$options += array('empty' => false);
		}
		if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time') {
			$dateFormat = $this->_extractOption('dateFormat', $options, 'MDY');
			$timeFormat = $this->_extractOption('timeFormat', $options, 12);
			unset($options['dateFormat'], $options['timeFormat']);
		}

		$type = $options['type'];
		$out = array_merge(
			array('before' => null, 'label' => null, 'between' => null, 'input' => null, 'after' => null, 'error' => null),
			array('before' => $options['before'], 'label' => $label, 'between' => $options['between'], 'after' => $options['after'])
		);
		$format = null;
		if (is_array($options['format']) && in_array('input', $options['format'])) {
			$format = $options['format'];
		}
		unset($options['type'], $options['before'], $options['between'], $options['after'], $options['format']);

		switch ($type) {
			case 'hidden':
				$input = $this->hidden($fieldName, $options);
				$format = array('input');
				unset($divOptions);
			break;
			case 'checkbox':
				$input = $this->checkbox($fieldName, $options);
				$format = $format ? $format : array('before', 'input', 'between', 'label', 'after', 'error');
			break;
			case 'radio':
				if (isset($out['between'])) {
					$options['between'] = $out['between'];
					$out['between'] = null;
				}
				$input = $this->radio($fieldName, $radioOptions, $options);
			break;
			case 'file':
				$input = $this->file($fieldName, $options);
			break;
			case 'select':
				$options += array('options' => array(), 'value' => $selected);
				$list = $options['options'];
				unset($options['options']);
				$input = $this->select($fieldName, $list, $options);
			break;
			case 'time':
				$options['value'] = $selected;
				$options['class'] = !empty($options['class']) ?  $options['class'] . ' timepicker' : 'timepicker'; // zuha specific
				$type = 'text'; // zuha specific
				$input = $this->{$type}($fieldName, $options); // zuha specific
				//$input = $this->dateTime($fieldName, null, $timeFormat, $options); // cakephp specific
			break;
			case 'date':
				$options['value'] = $selected;
				$options['class'] = !empty($options['class']) ?  $options['class'] . ' datepicker' : 'datepicker'; // zuha specific
				$type = 'text'; // zuha specific
				$input = $this->{$type}($fieldName, $options); // zuha specific
				// $input = $this->dateTime($fieldName, $dateFormat, null, $options); // cakephp specific
			break;
			case 'datetime':
				$options['value'] = $selected;
				$options['class'] = !empty($options['class']) ?  $options['class'] . ' datetimepicker' : 'datetimepicker'; // zuha specific
				$type = 'text'; // zuha specific
				$input = $this->{$type}($fieldName, $options); // zuha specific
				// $input = $this->dateTime($fieldName, $dateFormat, $timeFormat, $options); // cakephp specific
			break;
			case 'richtext': // zuha specific
				$input = $this->richtext($fieldName, $options + array('class' => 'CKEDITOR')); // zuha specific
			break; // zuha specific
			case 'textarea':
				$input = $this->textarea($fieldName, $options + array('cols' => '30', 'rows' => '6'));
			break;
			case 'url':
				$input = $this->text($fieldName, array('type' => 'url') + $options);
			break;
			default:
				$input = $this->{$type}($fieldName, $options);
		}

		if ($type != 'hidden' && $error !== false) {
			$errMsg = $this->error($fieldName, $error);
			if ($errMsg) {
				$divOptions = $this->addClass($divOptions, 'error');
				$out['error'] = $errMsg;
			}
		}

		$out['input'] = $input;
		$format = $format ? $format : array('before', 'label', 'between', 'input', 'after', 'error');
		$output = '';
		foreach ($format as $element) {
			$output .= $out[$element];
			unset($out[$element]);
		}

		if (!empty($divOptions['tag'])) {
			$tag = $divOptions['tag'];
			unset($divOptions['tag']);
			$output = $this->Html->tag($tag, $output, $divOptions);
		}
		return $output;
	}
	
	
/**
 * Parse the ajax output back to the form element
 * Created so that if there is a case where we need to do something to 
 * the form element not already covered we would do it here.
 */
	public function ajaxElement($attributes) {
		$attributes = array_merge($attributes, $attributes['ajax']);
		unset($attributes['ajax']);
		return $attributes;
	}


/**
 * Creates a rich text widget.
 *
 * ### Options:
 *
 * - `escape` - Whether or not the contents of the textarea should be escaped. Defaults to true.
 * - `buttons` - An array of buttons to include in the rich editor.  Defaults to simple.
 *
 * @param string $fieldName Name of a field, in the form "Modelname.fieldname"
 * @param array $options Array of HTML attributes, and special options above.
 * @return string A generated HTML text input element
 * @access public
 * @todo		Make buttons actually configurable. Right now only the default simple works. 
 * @todo		This would probably be a good place to choose the editor type as well.  So maybe we have more than just ckeditor supported. But make sure you check the first reference to "richtext" above, because the class CKEDITOR is defined up there.
 * @todo		Test that inner div id.  I'm not sure that it would be selectable as an identifier using css.
 */
	public function richtext($fieldName, $options = array()) {
		App::uses('CkeHelper', 'View/Helper');
		$Cke = new CkeHelper($this->View);
		$ckeSettings = $this->_ckeConfig($options);
		$options = $this->_initInputField($fieldName, $options);
		
		$fieldId = !empty($options['id']) ? $options['id'] : $options['name'];
		$value = null;
		
		if (array_key_exists('value', $options)) {
			$value = $options['value'];
			if (!array_key_exists('escape', $options) || $options['escape'] !== false) {
				$value = h($value);
			}
			unset($options['value']);
		}
		return $this->Html->useTag('richtext', $options['name'], array_diff_key($options, array('type' => '', 'name' => '')), $value, $this->Html->script('ckeditor/ckeditor').$this->Html->script('ckeditor/adapters/jquery'), $Cke->load($fieldId, $ckeSettings));
	}
	
	
/**
 * Config ckeditor  (zuha specific)
 */
	protected function _ckeConfig($options = array()) {
		if (!empty($options['ckeSettings'])) {
			$ckeSettings = $options['ckeSettings'];
		} else {
		}
		$ckeSettings['path'] = Configure::read('appPath').'/js/kcfinder/';
		
		return $ckeSettings;
	}

}
