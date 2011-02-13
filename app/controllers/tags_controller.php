<?php
/**
 * Tags Controller
 *
 * A central controller for handling tags throughout the app. If you need
 * to have a section which allows the end user to tag a record, it should be 
 * done with this controller. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class TagsController extends AppController {

	var $name = 'Tags';
	var $helpers = array('Html', 'Form');

	function admin_index() {
		$model = $this->modelClass;
		$this->$model->recursive = -1;
		$controller = $this->name;
		$this->set('outputs', $this->paginate());
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->set('autocomplete', true);
		$this->viewPath = 'pages';
		$this->render('edit_types');
	}

	function admin_ajax_complete() {
		$model = $this->modelClass;
		$this->set(strtolower($model).'s', $this->$model->find('all', array(
					'conditions' => array(
						$model.'.name LIKE' => $this->data[$model]['name'].'%'
					),
					'fields' => array('name')
		)));
		$this->layout = 'ajax';
		$this->viewPath = 'pages';
		$this->render('ajax_complete');
	}

	function admin_add() {
		$model = $this->modelClass;
		if (!empty($this->data)) {
			$this->$model->create();
			if ($this->$model->save($this->data)) {
				$this->Session->setFlash(__('The '.$model.' has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The '.$model.' could not be saved. Please, try again.', true));
			}
		}
	}
	
	function admin_edit($id = null) {
		if (!empty($this->data)) {
			$model = $this->modelClass;
			if ($this->$model->save($this->data)) {
				$this->Session->setFlash(__('The '.$model.' has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The '.$model.' could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->$model->read(null, $id);
		}
	}
	
	
	 function admin_ajax_update($id,$sub,$model){ 
		$model = Inflector::camelize($model);
		App::import('Model', $model);
		$this->$model = new $model();
		//Update the value in the database
        $value = $this->params['form']['value'];
        $this->$model->id = $id; 
        if (!$this->$model->saveField($sub, $value,true)) { 
             $this->set('error', true); 
			 echo $error;
        } 
        $contact = $this->$model->read(array($sub), $id); 
		// Get the display value for the field if the field is a foreign key
        // See if field to be updated is a foreign key and set the display value
        if (substr($sub,-3) == '_id'){
            // Chop off the "_id"
            $new_sub = substr($sub,0,strlen($sub)-3); 
            // Camelize the result to get the Model name
            $model_name = Inflector::camelize($new_sub);
			App::import('Model', $model_name);
			$this->$model_name = new $model_name();
            // See if the model has a display name other than default "name"; 
		if (!empty($this->$model_name->displayField)){
                $display_field = $this->$model_name->displayField; 
            }else {
                $display_field = 'name';
            }
                        // Get the display value for the id
            $value = $this->$model_name->field($display_field,array('id' => $value));
        }

		// Set the view variable and render the view.
        $this->set('value',$value); 
		$this->viewPath = 'pages';
		$this->render('ajax_update');
    } 
	
	function admin_ajax_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id', true));
			$this->redirect(array('action'=>'index'));
		}
		$model = $this->modelClass;
		if ($this->$model->delete($id)) {
			$this->redirect('/ajax_delete');
	        $this->layout = 'ajax';
		}
	}

}
?>