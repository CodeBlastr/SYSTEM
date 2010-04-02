<?php
class ContactsTagsController extends AppController {

	var $name = 'ContactsTags';

	function admin_index() {
		$model = $this->modelClass;
		$controller = $this->name;
		$this->$model->contain('Tag');
		$filterField = strtolower(str_replace('sTag','_id',$model));
		$outputs = $this->$model->find('all', array('conditions' => array($model.'.'.$filterField => $this->params['named'][$filterField])));
		$this->set('outputs',$outputs);
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->set('autocomplete', true);
		$this->viewPath = 'pages';
		$this->render('add_tags');
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
		App::import('Model', 'Tag');
		$this->Tag = new Tag;
		$tag_name = $this->data['Tag']['name'];
		$tag_info = $this->Tag->find('first', array('fields' => 'id, count', 'conditions' => array('Tag.name' => $tag_name)));
		$this->data['Tag']['count'] = $tag_info['Tag']['count'] + 1;
		$filterField = strtolower(str_replace('Tag','_id',$model));
		if (!empty($tag_info['Tag']['id'])) {
			$this->data[$model]['tag_id'] = $tag_info['Tag']['id'];
			$this->$model->create();
			if ($this->$model->save($this->data) && $this->Tag->updateAll(array('Tag.count' => 'Tag.count + 1'), array('Tag.id' => $tag_info['Tag']['id']))) {
				$this->Session->setFlash(__('The '.$model.' has been saved', true));
				$this->redirect(Controller::referer());
			} else {
				$this->Session->setFlash(__('The '.$model.' could not be saved. Please, try again.', true));
			}
		} else {			
			if ($this->Tag->save($this->data)) {
				$insert_id = $this->Tag->id;
				$this->data[$model]['tag_id'] = $insert_id;
				if ($this->$model->save($this->data)) {
					$this->Session->setFlash(__('The '.$model.' has been saved', true));
					$this->redirect(Controller::referer());
				} else {
					$this->Session->setFlash(__('The '.$model.' could not be saved. Please, try again.', true));
				}
			}
		}
		$this->viewPath = 'pages';
		$this->render('add_tags');
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
		$tag_id = $this->$model->find('first', array('fields' => 'tag_id','conditions' =>  array($model.'.id' => $id)));	
		App::import('Model', 'Tag');
		$this->Tag = new Tag;
		$tag_info = $this->Tag->find('first', array('fields' => 'id, count', 'conditions' => array('Tag.id' => $tag_id[$model]['tag_id'])));
		$tag_count = $tag_info['Tag']['count'] - 1;
		if ($this->Tag->updateAll(array('Tag.count' => $tag_count), array('Tag.id' => $tag_info['Tag']['id']))) {
			if ($this->$model->del($id)) {
				$this->redirect('/ajax_delete');
	    	    $this->layout = 'ajax';
			}
		}
	}

}
?>