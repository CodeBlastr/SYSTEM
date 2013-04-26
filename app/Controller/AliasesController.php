<?php
App::uses('AppController', 'Controller');
/**
 * Aliases Controller
 *
 * Aliases are for giving a shorter, nicer looking permanent url to any page. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class AliasesController extends AppController {

/**
 *
 * @var string
 */
	public $name = 'Aliases';

/**
 *
 * @var string
 */
	public $uses = 'Alias';
    
/**
 * Index method
 * 
 */
    public function index() {
        $this->paginate['fields'] = array(
            'Alias.id',
            'Alias.name',
            'Alias.plugin',
            'Alias.controller',
            'Alias.value',
            );
        $this->set('aliases', $this->paginate());
        $this->set('displayName', 'name');
        $this->set('displayDescription', '');
        $this->set('page_title_for_layout', 'Aliases');
    }

/**
 * Edit method
 * 
 * @param string $id
 */
    public function edit($id = null) {
        $this->Alias->id = $id;
        if (!$this->Alias->exists()) {
            throw new NotFoundException();
        }
        if (!empty($this->request->data)) {
            if ($this->Alias->save($this->request->data)) {
                $this->Session->setFlash(__('Alias saved'));
                $this->redirect(array('controller' => 'aliases', 'action' => 'index'));
            }
        }
        $this->request->data = $this->Alias->read(null, $id);
    }

/**
 * Delete method
 * 
 * @param string $id
 */
    public function delete($id = null) {
        $this->Alias->id = $id;
        if (!$this->Alias->exists()) {
            throw new NotFoundException();
        }
        if ($this->Alias->delete($id)) {
            $this->Session->setFlash(__('Alias deleted'));
            $this->redirect(array('controller' => 'aliases', 'action' => 'index'));
        }
    }

/**
 * Count method
 * 
 * Look for an alias to see if it already exists, plus 10 variations
 * 
 * @param string $name
 */
	public function count($name = null) {
        $name = str_replace('+', '/', $name);
        $names[] = $name;
        for($i = 0; $i < 10; $i++){
            $names[] = $name . $i;
        }
		$this->set('alias', $this->Alias->find('count', array('conditions' => array('Alias.name' => $names), 'fields' => 'Alias.id')));
	}

}