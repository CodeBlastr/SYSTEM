<?php
/**
 * Template Component
 * 
 * Allows you to attach templates to individual records during any of the specified actions in the actions settings variable.
 * 
 * Usage : 
 * 1. Make sure that the ThemeableBehavior is attached to the model for the controller using this component
 * 2. Add a form element to your form view.  eg.   echo !empty($layouts) ? $this->Form->input('Theme.layout', array('type' => 'radio')) : null;
 */
class TemplateComponent extends Component {
    
    public $Controller = null;
	
/**
 * Var defaults
 * 
 * An array of actions this component is allowed to edit the viewVars for.
 */
	public $defaults = array(
		'actions' => array(
			'add',
			'edit'
			),
		);
	
/**
 * Start up method
 */
    public function startup(Controller $Controller) {
    	$this->settings = !empty($this->settings) ? $this->settings : $this->defaults;
    	if (in_array($Controller->request->params['action'], $this->settings['actions'])) {
			$Template = ClassRegistry::init('Template');
			$Controller->set('layouts', Set::merge(array('' => 'default'), $Template->find('list', array('fields' => array('Template.layout', 'Template.layout'), 'conditions' => array('Template.is_usable' => 1, 'Template.model' => null, 'Template.foreign_key' => null)))));
    	}
    }
    
    public function beforeRender(Controller $Controller) {
    	// The beforeRender method is called after the controller executes the requested action’s logic but before the controller’s renders views and layout.
    }
    
    public function shutdown(Controller $Controller) {
    	// The shutdown method is called before output is sent to browser.
    }
	
}