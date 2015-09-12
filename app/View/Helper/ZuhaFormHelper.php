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
			
			// this code is extremely slow, it can cause pages to take two minutes to load
			$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
			$json = json_decode(file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/forms/forms/secure.json', false, $context));
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

		return $this->View->Html->useTag('richtext', $preLinks, $options['name'], array_diff_key($options, array('type' => '', 'name' => '')), $value, $this->View->Html->script('ckeditor/ckeditor', array('inline' => false)), $Cke->load($fieldId, $ckeSettings));
	}

	public function simpletext($fieldName, $options = array()){
		$options['hideToggleLinks'] = true;
		$defaultSettings = array(
			'buttons'=>array('Bold','Italic','Underline',
				'-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList','Blockquote'),
		);
		if(is_array($options['ckeSettings'])){
			$options['ckeSettings'] = array_merge_recursive($options['ckeSettings'],$defaultSettings);
			//remove duplicates buttons
			$options['ckeSettings']['buttons'] = array_flip(array_flip($options['ckeSettings']['buttons']));
		}else{
			$options['ckeSettings'] = $defaultSettings;
		}
		 ;
		$returnValue = $this->simplebuttons().$this->richtext($fieldName,$options);
		if($options['simpleButtons'] === false){
			$returnValue = $this->richtext($fieldName,$options);
		}
		return $this->View->Html->script('ckeditor/config-simple',array('inline'=>false)) . $returnValue;
	}
	public function simplebuttons(){
		$defaultButtons = <<<EOD
<div id="editor-buttons">
		<button type="button" class="text" data-action="text">Text</button>
		<button type="button" class="audios" data-action="audios">Audios</button>
		<button type="button" class="videos" data-action="videos">Videos</button>
		<button type="button" class="links" data-action="links">Links</button>
		<button type="button" class="documents" data-action="documents">Documents</button>
		<button type="button" class="photos" data-action="photos">Photos</button>
	</div>
EOD;
		return $defaultButtons;
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
 * Date picker method
 */
	public function datepicker($fieldName, $attributes = array(), $dateFormat = 'm/d/Y') {
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
		} 
		if (empty($attributes['id'])) {
			// make sure the id is unique, else the javascript will not attach to the input
			$attributes['id'] = Inflector::camelize(Inflector::slug($fieldName . mt_rand()));
		}
		// else {  We should not force today's date, onto the field, if you want today's date as default then use array('default' => date()); as a the Form->input() option.
			// $attributes['value'] = $attributes['value'] === null ? date($dateFormat) : $attributes['value'];
		// }
		
		$attributes['class'] = !empty($attributes['class']) ? $attributes['class'] . ' date-picker' : 'date-picker';
		
		$firstId = !empty($attributes['id']) ? $attributes['id'] : Inflector::camelize(Inflector::slug($fieldName)); // same as taken from FormHelper
		$this->View->Html->css('//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', null, array('inline' => false));
		$this->View->Html->css('jquery-ui/jquery-ui-timepicker-addon', null, array('inline' => false));
		$this->View->Html->script('jquery-ui/jquery-ui-1.10.3.custom', array('inline' => false, 'once' => true));
		$this->View->Html->script('plugins/jquery-ui-timepicker-addon', array('inline' => false, 'once' => true));
		$jsTime = isset($attributes['jsTimeFormat']) ? $attributes['jsTimeFormat'] : 'HH:MM:ss';
		$jsDate = isset($attributes['jsDateFormat']) ? $attributes['jsDateFormat'] : 'mm/dd/yy';
		$fieldhiddenname = $firstId . '_';
		$value = !empty($attributes['value']) ? date('Y-m-d', strtotime($attributes['value'])) : null;
		$code = '$(document).ready(function() {
			$("#' . $firstId . '").next().val("' . $value . '");
			$("#' . $firstId . '").datepicker({
				onClose: function(dateText,datePickerInstance) {
					if (!$(this).val()) {
						$.datepicker._clearDate(this);
					}
				},
		    	timeFormat: "' . $jsTime . '", 
		        dateFormat: "' . $jsDate . '",
		        altField: "#' . $fieldhiddenname . '",
		        altFormat: "yy-mm-dd",
		        changeMonth:true,
		        changeYear:true
			}); 
		});';

		$this->View->Html->scriptBlock($code, array('inline' => false, 'once' => false));
		
		// return a text field plus a hidden field with proper Y-m-d h:i:s format
		return $this->text($fieldName, array(
			'type' => 'text',
		) + $attributes) . $this->hidden($fieldName, array('id' => $fieldhiddenname));
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
		} elseif(isset($attributes['required'])) {
			$attributes['value'] = date($dateFormat);
		} else {
			$attributes['value'] = null;
		}
		
		!empty($attributes['class']) ? $attributes['class'] = $attributes['class'] . ' date-time-picker' : $attributes['class'] = 'date-time-picker';
		
		$firstId = !empty($attributes['id']) ? $attributes['id'] : Inflector::camelize(Inflector::slug($fieldName)); // same as taken from FormHelper
		$this->View->Html->css('//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', null, array('inline' => false));
		$this->View->Html->css('jquery-ui/jquery-ui-timepicker-addon', null, array('inline' => false));
		$this->View->Html->script('jquery-ui/jquery-ui-1.10.3.custom', array('inline' => false, 'once' => true));
		$this->View->Html->script('plugins/jquery-ui-timepicker-addon', array('inline' => false, 'once' => true));
		$jsTime = isset($attributes['jsTimeFormat']) ? $attributes['jsTimeFormat'] : 'hh:mm tt';
		$jsDate = isset($attributes['jsDateFormat']) ? $attributes['jsDateFormat'] : 'mm/dd/yy';
        $disable = isset($attributes['disablepast']) ? 'minDate: 0,' : '';
		$fieldnameId = str_replace(' ', '', ucwords(str_replace('.', ' ', $fieldName))); // comment why, if you comment this line out
		$fieldhiddenname = $fieldnameId . '_';
		$code = '$(document).ready(function() {
			// fixing a conflict and removed these two lines in favor of the two below it
			// $("#'.$fieldnameId.'").next().val("' . date('Y-m-d h:i:s', strtotime($attributes['value'])) . '");
			// $("#'.$fieldnameId.'").datetimepicker({
			$("#' . $firstId . '").next().val("' . date('Y-m-d h:i:s', strtotime($attributes['value'])) . '");
			$("#' . $firstId . '").datetimepicker({
		    	timeFormat: "' . $jsTime . '",
		        dateFormat: "' . $jsDate . '",
		        altField: "#' . $fieldhiddenname . '",
		        '.$disable.'
		        altFieldTimeOnly: false,
		        altFormat: "yy-mm-dd",
		        altTimeFormat: "HH:mm:ss",
		        altSeparator: " "
			});
		});';
		$this->View->Html->scriptBlock($code, array('inline' => false, 'once' => false));
		
		// return a text field plus a hidden field with proper Y-m-d h:i:s format
		return $this->text($fieldName, array(
			'type' => 'text',
		) + $attributes) . $this->hidden($fieldName, array_merge($attributes, array('id' => $fieldhiddenname)));
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


	public function tags($fieldName, $options = array()) {
//		App::uses('Tag', 'Tags.Model');
//		$this->Tag = new Tag();
// 		$tags = $this->Tag->find('all', array(
//			'conditions' => array('creator_id' => $this->View->getVar('__userId')),
//			'fields' => 'name'
//		));
//		$tagNames = Hash::extract($tags, "{n}.Tag.name");
//		foreach ($tagNames as &$tagName) {
//			//$objects[] = '{ val: "'.$tagName.'" }';
//			$tagName = json_encode($tagName);
//		}
//		$jsObject = implode(',', $tagNames);
		echo $this->View->Html->css('/tags/css/bootstrap-tagsinput');
		echo $this->View->Html->script('/tags/js/bootstrap-tagsinput.min');
		#echo $this->View->Html->script('/tags/js/typeahead.jquery.min');
		$options['data-role'] = 'tagsinput';
		$typeahead = "
			<script>
//var engine = new Bloodhound({
//	name: 'tags',
//	//local: [{ val: 'dog' }, { val: 'pig' }, { val: 'moose' }],
//	local: [{$jsObject}],
//	//remote: '/tags/tags/ajax?q=%QUERY',
//	datumTokenizer: function(d) {
//		return Bloodhound.tokenizers.whitespace(d.val);
//	},
//	queryTokenizer: Bloodhound.tokenizers.whitespace
//});
//
//engine.initialize();
//
////$('.typeahead').typeahead(null, {
////  source: engine.ttAdapter()
////});
//
//$('input[data-role=\"tagsinput\"]').typeahead({
//   source: engine.ttAdapter()
//}).bind('typeahead:selected', $.proxy(function (obj, datum) {  
//  this.tagsinput('add', datum.value);
//  this.tagsinput('input').typeahead('setQuery', '');
//}, $('input')));

//$('input[data-role=\"tagsinput\"]').tagsinput({
//	typeahead: {
//		source: [$jsObject],
//		freeInput: true
//	}
//});

//$('input[data-role=\"tagsinput\"]').tagsinput('input').typeahead({
//	source: [$jsObject],
//	freeInput: true
//});

</script>
";
		return $this->text($fieldName, $options);
	}

}
