<?php

App::uses('ClassRegistry', 'Utility');
App::uses('FormHelper', 'View/Helper');
App::uses('Hash', 'Utility');

/**
 * Form helper library.
 *
 * Automatic generation of HTML FORMs from given data.
 *
 * @package       Cake.View.Helper
 * @property      HtmlHelper $Html
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html
 */
class ZuhaFormHelper extends FormHelper {
	
/**
 * Copies the validationErrors variable from the View object into this instance
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$this->View = $View;
	}

/**
 * Add a form key after two seconds to help secure the form.
 */
	public function create($model = null, $options = array()) {
		if ($options['secure'] === true) {
			// this piece is copied from the parent function, because we need the id earlier
			if (!isset($options['id'])) {
				$domId = isset($options['action']) ? $options['action'] : $this->request['action'];
				$options['id'] = $this->domId($domId . 'Form');
			}
			// hash the form action to write into settings, as a form that must be checked
			$settingValue = 'c' . Security::hash($this->url($this->_getAction($options)), 'md5', Configure::read('Security.salt'));
			// this is how we know which forms have to be checked on the catch side
			if (defined('__APP_SECURE_FORMS')) {
				// read settings
				$values = unserialize(__APP_SECURE_FORMS);
				$saveNewForm = false;
				if (!in_array($settingValue, $values['form'])) {
					// add to settings if it isn't in there already
					array_push($values['form'], $settingValue);
					$value = '';
					foreach ($values['form'] as $formId) {
						$value .= 'form[] = ' . $formId . PHP_EOL;
					}
					$saveNewForm = true;
				}
			} else {
				// add setting value
				$value = 'form[] = ' . $settingValue;
				$saveNewForm = true;
			}
			if (!empty($saveNewForm)) {
				$Setting = ClassRegistry::init('Setting');
				$data['Setting']['type'] = 'App';
				$data['Setting']['name'] = 'SECURE_FORMS';
				$data['Setting']['value'] = $value;
				$Setting->add($data);
			}
			$json = json_decode(file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/forms/forms/secure.json'));
			echo '<script type="text/javascript">
			        jQuery(document).ready(function() {
			          var timeOut = window.setTimeout(function() { jQuery("#' . $options['id'] . '").prepend("<input type=\"hidden\" name=\"data[FormKey][id]\" value=\"' . $json->key . '\" />"); }, 10000);
			        });
			      </script>';
		}

		if ($options['action'] === null && $options['url'] === null) {
			// zuha over writes the the action if it isn't specified to preserve the prefix and query string (cake < 2.4 did for us)
			$options['url'] = $_SERVER['REQUEST_URI'];
		}
		return parent::create($model, $options);
	}

/**
 * get action (taken from original form helper)
 */
	protected function _getAction($options) {
		if ($options['action'] === null && $options['url'] === null) {
			$options['action'] = $this->request->here(false);
		} elseif (empty($options['url']) || is_array($options['url'])) {
			if (empty($options['url']['controller'])) {
				if (!empty($model) && $model != $this->defaultModel) {
					$options['url']['controller'] = Inflector::underscore(Inflector::pluralize($model));
				} elseif (!empty($this->request->params['controller'])) {
					$options['url']['controller'] = Inflector::underscore($this->request->params['controller']);
				}
			}
			if (empty($options['action'])) {
				$options['action'] = $this->request->params['action'];
			}
			$plugin = null;
			if ($this->plugin) {
				$plugin = Inflector::underscore($this->plugin);
			}
			$actionDefaults = array(
				'plugin' => $plugin,
				'controller' => $this->_View->viewPath,
				'action' => $options['action'],
			);
			$options['action'] = array_merge($actionDefaults, (array)$options['url']);
			if (empty($options['action'][0]) && !empty($id)) {
				$options['action'][0] = $id;
			}
		} elseif (is_string($options['url'])) {
			$options['action'] = $options['url'];
		}
		return $options['action'];
	}

/**
 *  Added by Zuha to parse extra fields needed for ajax
 */
	public function select($fieldName, $options = array(), $attributes = array()) {
		// Added by Zuha to parse extra fields needed for ajax
		if (isset($attributes['ajax'])) {
			$attributes = $this->ajaxElement($attributes);
		}
		$selectElement = parent::select($fieldName, $options, $attributes);
		if (isset($attributes['limit']) && $attributes['multiple'] == 'checkbox') {
			$matches = explode('.', $fieldName);
			$name = 'data';
			foreach ($matches as $match) {
				$name .= '[' . $match . ']';
			}
			$name .= '[]';
			$selectElement .= '
				<script type="text/javascript">
					$(document).ready(function() {
					  $("input[name=\'' . $name . '\'").click(function() {
					    if ( $("input[name=\'' . $name . '\']:checked").length > ' . $attributes['limit'] . ' ) {
					      alert("You may only choose a maximum of ' . $attributes['limit'] . '");
					      $(this).prop("checked", false);
					    }
					  });
					});
				</script>';
		}
		return $selectElement;
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
 * @todo    Make buttons actually configurable. Right now only the default simple
 * works.
 * @todo    This would probably be a good place to choose the editor type as
 * well.  So maybe we have more than just ckeditor supported. But make sure you
 * check the first reference to "richtext" above, because the class CKEDITOR is
 * defined up there.
 * @todo    Test that inner div id.  I'm not sure that it would be selectable as
 * an identifier using css.
 */
	public function richtext($fieldName, $options = array()) {
		$preLinks = $options['hideToggleLinks'] !== true ? 
			'<div class="ckeditorLinks">
				<a id="' . $fieldName . '_exec-source" class="exec-source"><i class="icon-wrench"></i> HTML</a>
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a onclick="toggleExtras();" id="toggle-extras"><i class="icon-fire"></i> TOGGLE EXTRAS</a>
			</div>' : 
			null;
			
		$options['class'] = !empty($options['class']) ? $options['class'] . ' ckeditor' : 'ckeditor';
				
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
		return $this->Html->useTag('richtext', $preLinks, $options['name'], array_diff_key($options, array('type' => '', 'name' => '')), $value, $this->Html->script('ckeditor/ckeditor', array('inline' => false)), $Cke->load($fieldId, $ckeSettings));
	}

/**
 * Config ckeditor  (zuha specific)
 */
	protected function _ckeConfig($options = array()) {
		if (!empty($options['ckeSettings'])) {
			$ckeSettings = $options['ckeSettings'];
		}
		$ckeSettings['path'] = Configure::read('appPath') . '/js/kcfinder/';
		return $ckeSettings;
	}

/**
 * Date time picker method
 */
	public function datetimepicker($fieldName, $attributes = array(), $dateFormat = 'm/d/Y h:i a', $timeFormat = '24') {
		$this->setEntity($fieldName);
		$attributes += array(
			'empty' => true,
			'value' => null
		);
		if (empty($attributes['value'])) {
			$attributes = $this->value($attributes, $fieldName);
		}
		if (!empty($attributes['value'])) {
			$attributes['value'] = date($dateFormat, strtotime($attributes['value']));
		} else {
			$attributes['value'] = date($dateFormat);
		}
		
		!empty($attributes['class']) ? $attributes['class'] = $attributes['class'] . ' date-time-picker' : $attributes['class'] = 'date-time-picker';
		
		$firstId = !empty($attributes['id']) ? $attributes['id'] : Inflector::camelize(Inflector::slug($fieldName)); // same as taken from FormHelper
		$this->View->Html->css('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', null, array('inline' => false));
		$this->View->Html->css('jquery-ui/jquery-ui-timepicker-addon', null, array('inline' => false));
		$this->View->Html->script('jquery-ui/jquery-ui-1.10.3.custom', array('inline' => false));
		$this->View->Html->script('plugins/jquery-ui-timepicker-addon', array('inline' => false));
		$jsTime = isset($attributes['jsTimeFormat']) ? $attributes['jsTimeFormat'] : 'hh:mm tt';
		$jsDate = isset($attributes['jsDateFormat']) ? $attributes['jsDateFormat'] : 'mm/dd/yy';
		$code = '$(document).ready(function() {
			$("#' . $firstId . '").next().val("' . date('Y-m-d h:i:s', strtotime($attributes['value'])) . '");
			$("#' . $firstId . '").datetimepicker({
		    	timeFormat: "' . $jsTime . '", 
		        dateFormat: "' . $jsDate . '",
		        altField: "#' . str_replace('.', '', $fieldName) . '_",
		        altFieldTimeOnly: false,
		        altFormat: "yy-mm-dd",
		        altTimeFormat: "hh:mm:ss",
		        altSeparator: " "
			});
		});';
		$this->View->Html->scriptBlock($code, array('inline' => false, 'once' => false));
		
		// return a text field plus a hidden field with proper Y-m-d h:i:s format
		return $this->text($fieldName, array(
			'type' => 'text',
		) + $attributes) . $this->hidden($fieldName, array('id' => str_replace('.', '', $fieldName) . '_'));
	}

/**
 * radio method override for purchasable option
 *
 * ex.
 * echo $this->Form->input('Category.Category', array(
 *    'type' => 'radio',
 *    'purchasable' => true, // must be set to true
 *    'combine' => array('{n}.Category.id', '{n}.Category.name'), // what the
 * list should look like
 *    'options' => $categories  // a full data array from find "all", not a
 * normal find "list" type
 *    ));
 *
 */
	public function radio($fieldName, $options = array(), $attributes = array()) {
		if ($attributes['purchasable'] === true && !empty($attributes['combine'])) {
			$combine = explode('.', $attributes['combine'][0]);
			$key = $combine[2];
			$combine = explode('.', $attributes['combine'][1]);
			$model = $combine[1];
			$value = $combine[2];
			unset($attributes['purchasable']);
			unset($attributes['combine']);
			$out = '';
			for ($i = 0; $i < count($options); $i++) {
				$id = $options[$i][$model][$key];
				$label = $options[$i][$model][$value];
				if ($i > 0) {
					$attributes['hiddenField'] = false;
					// because we're doing individual radio buttons we need to remove all but the
					// first hidden field as it would be normally
				}
				if (!empty($options[$i]['Product']) && empty($options[$i]['TransactionItem'])) {
					// must be purchased, and hasn't been yet (in the
					// Products/Model/Behavior/PurchasableBehavior)
					$out .= parent::radio($fieldName, array($id => __('<span style="text-decoration: line-through">%s</span> <a href="/products/products/view/%s" class="btn btn-mini btn-success">Buy</a>', $label, $options[$i]['Product']['id'])), $attributes + array('disabled' => 'disabled'));
				} else {
					$out .= parent::radio($fieldName, array($id => $label), $attributes);
				}
			}
			//$options = Set::combine($options, $attributes['combine'][0],
			// $attributes['combine'][1]);
			return $out;
		} else {
			return parent::radio($fieldName, $options, $attributes);
		}
	}

}
