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
    
    public function initialize(Controller $Controller) {
    	//The initialize method is called before the controller’s beforeFilter method.
        if (end($Controller->request->params['pass']) == 'template') {
			return $this->template($Controller);
        }
		
        if ($Controller->request->action == 'template') {
			return $this->templateEdit($Controller);
        }
    }
	
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
	
	public function template(Controller $Controller) {
		if (!empty($Controller->request->pass[0])) {
			$model = $Controller->modelClass;
			$foreignKey = $Controller->request->pass[0];
			$Template = ClassRegistry::init('Template');
			//$Template->bindModel(array('belongsTo' => array($model => array('foreignKey' => 'foreign_key'))));
			$template = $Template->find('count', array('conditions' => array('Template.model' => $model, 'Template.foreign_key' => $foreignKey)));
			if (!empty($template)) {
				$Controller->set('templateEditing', 1);
			} else {
				debug('Template was not found');
				break;
				throw new NotFoundException();
			}
		} else {
			debug('Template was not found');
			break;
			throw new NotFoundException();
		}
	}
	
	public function templateEdit(Controller $Controller) {
		$Controller->render(false);
		$Controller->layout = false;
		$boxes = json_decode($Controller->request->data);
		if (!empty($boxes) && is_array($boxes)) {
			$Template = ClassRegistry::init('Template');
			$template = $Template->find('first', array('conditions' => array('Template.model' => $Controller->modelClass, 'Template.foreign_key' => $Controller->request->params['pass'][0])));
			$settings = unserialize($template['Template']['settings']);
			$settings['elements'] = $boxes;
			$data['Template']['id'] = $template['Template']['id'];
			$data['Template']['settings'] = serialize($settings);
			if ($Template->save($data)) {
				echo 'true';
				die;
			} else {
				echo 'false';
				die;
			}
		} else {
			echo 'false';
			die;
		}
	}
	
}