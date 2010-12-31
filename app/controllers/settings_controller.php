<?php
/**
 * Settings Controller
 *
 * Used to set global constants that can be used throughout the entire app.
 * All data in this table is loaded on app start up (and hopefully cached).
 * The purpose is to have a central database driven place where you can customize
 * the application. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Make sure that settings are cached for a very long time, because they are not needed to be refreshed often at all. 
 */
class SettingsController extends AppController {

	var $name = 'Settings';
    var $uses = array('Setting', 'Template');

	function index() {
		$this->Setting->recursive = 0;
		$this->set('settings', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Setting.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('setting', $this->Setting->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Setting->create();
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Setting->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Setting->delete($id)) {
			$this->Session->setFlash(__('Setting deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Setting->recursive = 0;
		$this->set('settings', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Setting.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('setting', $this->Setting->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Setting->create();
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The Setting has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Setting could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Setting->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Setting->delete($id)) {
			$this->Session->setFlash(__('Setting deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

    // Function convert array multi_templates_ids into setting parameter and save them
    private function update_templates()
    {
        $setting_str = '';
        foreach($this->multi_templates_ids as $template)
        {
            $template_str = '{'.$template['template_id'].'}';
            $template_str .= '{'.$template['plugin'].'.'.$template['controller'].'.'.$template['action'].'.'.$template['parameter'].'}';
            $setting_str .= $template_str.',';
        }
        // removing last comma
        $setting_str = substr($setting_str, 0, strlen($setting_str) - 1);
        $data = $this->Setting->find('first', array(
            'conditions' => array('Setting.value LIKE' => '%MULTI_TEMPLATE_IDS%'),
            'limit' => 1
        ));
        
        // Updating setting which contain MULTI_TEMPLATE_IDS
        $value_str = $data['Setting']['value'];
        $values = explode(';', $value_str);
        for($i = 0; $i < count($values); $i++)
        {
            $setting = explode(':', $values[$i]);
            if($setting[0] == 'MULTI_TEMPLATE_IDS')
            {
                $values[$i] = implode(':',array(0 => $setting[0], 1 => $setting_str));
                break;
            }
        }
        $data['Setting']['value'] = implode(';', $values);
        $this->Setting->save($data);
    }


    function admin_templates() {
        $this->Template->records = $this->multi_templates_ids;
        $data = $this->paginate();
		$this->set('templates', $this->Template->find('all'));
	}

    function admin_templates_edit($id = null) {
        if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Setting', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
            foreach($this->data['Template'] as $key => $value )
            {
                $this->data['Template'][$key] = trim($value);
            }
            $this->Template->set($this->data);
            if($this->Template->validates()) {
                $this->multi_templates_ids[$id] = $this->data['Template'];
                $this->update_templates();
			    $this->Session->setFlash(__('The Template has been saved', true));
			    //$this->redirect(array('controller'=>'admin' ,'action'=>'settings'));
                $this->redirect(array('action'=>'templates'));
            }
            else {
                $this->Session->setFlash(__('Errors in fields', true));
            }
		}
		if (empty($this->data)) {
			$this->data['Template'] = $this->multi_templates_ids[$id];
		}
	}

    function admin_templates_add() {
        if(!empty($this->data))
        {
            $this->Template->set($this->data);
            if($this->Template->validates()) {
                $this->multi_templates_ids[] = $this->data['Template'];
                $this->update_templates();
                $this->Session->setFlash(__('The Template has been saved', true));
                $this->redirect(array('action'=>'templates'));
            }
            else {
                $this->Session->setFlash(__('Errors in fields', true));
            }
        }
    }

    function admin_templates_delete($id = null) {
		if (!$id || ($id < 1 || $id > count($this->multi_templates_ids))) {
			$this->Session->setFlash(__('Invalid id for Template', true));
			$this->redirect(array('action'=>'templates'));
        }
        // deleting templdate by id
        $new_templates = array();
        for($i = 1; $i <= count($this->multi_templates_ids); $i++)
        {
            if($i != $id)
                $new_templates[] = $this->multi_templates_ids[$i];
        }
        $this->multi_templates_ids = $new_templates;
		$this->update_templates();
        $this->Session->setFlash(__('Template deleted', true));
        $this->redirect(array('action'=>'templates'));
	}
}
?>