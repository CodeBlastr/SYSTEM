<?php 
/**
 * A helper for adding html around the template tags
 */
class TagCallbackHelper extends AppHelper {
		
	public $initialized = false;
	
	public $options = array('tags' => array('{helper: content_for_layout}'));
	
	public $beforeTag = '';  // actual html output wanted before the template tag
	
	public $afterTag = ''; // actual html output wanted after the template tag
	
	
	public function __construct($options = array()) {
		if (!empty($options)) {
			$this->options = array_merge($this->options, $options);
		}
		$this->initialized = true;
	}
	
	
	public function beforeRender() {
		# import the view variables
        $view =& ClassRegistry::getObject('view'); 
		
		$out = '';
		foreach ($this->options['tags'] as $tag) {
			if (!empty($tag)) {
				$out .= str_replace(
					$tag, // the template tag to be replaced : defaults to {helper: content_for_layout}
					$this->beforeContent.$tag.$this->afterContent, // do the replacement
					$view->viewVars['defaultTemplate']['Webpage']['content'] // on the view template 
					);
			} else {
				$out .= $view->viewVars['defaultTemplate']['Webpage']['content']; // on the view template
			}				
		}
		
		$view->viewVars['defaultTemplate']['Webpage']['content'] = $out;
	}
}
?>
