<?php 
/**
 * A helper for adding html around the template tags
 */
class TagCallbackHelper extends AppHelper {
		
	public $initialized = false;
	
	public $options = array(
		'tags' => array('{helper: content_for_layout}'),
		'beforeTag' => '',
		'afterTag' => '',
		);
	
	
	public function __construct($options = array()) {
		if (!empty($options)) {
			$this->options = array_merge($this->options, $options);
		}		
		$this->initialized = true;
	}
	
	
	/**
	 * Out put the html supplied around the template tag supplied
	 * 
	 * @todo	If we take the function called parseIncludedPages from the webpages controller and move it back to the /views/layouts/default.ctp file, then this function would also work on template tags with this format : {page: X} : Right now this works on {element: xxx.xxx.x}, {form: x/xxx}, {helper: xxxxxx}. 
	 */
	public function beforeRender() {
		# import the view variables
        $view =& ClassRegistry::getObject('view'); 
		
		$out = '';
		foreach ($this->options['tags'] as $tag) {
			if (!empty($tag)) {
				$out .= str_replace(
					$tag, // the template tag to be replaced : defaults to {helper: content_for_layout}
					$this->options['beforeTag'].$tag.$this->options['afterTag'], // do the replacement
					$view->viewVars['defaultTemplate']['Webpage']['content'] // on the view template 
					);
			} else {
				$out .= $view->viewVars['defaultTemplate']['Webpage']['content']; // on the view template
			}				
		}
		
		$view->viewVars['defaultTemplate']['Webpage']['content'] = $out;
	}
	
	public function beforeTag($html = '') {
		$this->beforeTag = $html;
	}
}
?>
