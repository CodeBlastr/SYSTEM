<?php
App::uses('WebpagesAppController', 'Webpages.Controller');

class FileController extends WebpagesAppController {

/**
 * Name
 * 
 * @var string
 */
    public $name = 'File';

/**
 * Uses
 * 
 * @var string
 */
    public $uses = '';
    
/**
 * Edit method
 * 
 * Edits the view file for the specified params
 * 
 * @param string $plugin
 * @param string $controller
 * @param string $action
 */
    public function edit($plugin, $controller = null, $action = null) {
        App::uses('Folder', 'Utility');
        App::uses('File', 'Utility');
        $plugin = Inflector::camelize($plugin);
        if (!in_array($plugin, CakePlugin::loaded())) {
            $this->Session->setFlash(__('This file cannot be customized'));
            $this->redirect($this->referer());
        }
        $controller = Inflector::camelize($controller);
        $paths = App::path('View', $plugin);
        $action = !empty($this->request->params['named']['view']) ? $this->request->params['named']['view'] : $action; 
        
        if ($this->request->is('post')) {
            // otherwise create the folder and write the file
            if (!file_exists($paths[0] . $controller)) {
                // create the folder first
                $folder = new Folder();
                if ($folder->create($paths[0] . $controller)) {
                    // Successfully created the nested folders
                } else {
                    throw new Exception(__('Could not create folder, check permissions'));
                }
            }
            $file = new File($paths[0] . $controller . DS . $action . '.ctp');
            if ($file->write($this->request->data['ViewFile']['contents'])) {
                // created file
                $this->Session->setFlash(__('%s Updated', $controller . DS . $action . '.ctp'));
                $this->redirect($this->referer());
            } else {
                throw new Exception(__('File save failed.'));
            }
        }
        
        // view Vars        
        foreach ($paths as $path) {
            if (file_exists($path . $controller . DS . $action . '.ctp')) {
                $file = new File($path . $controller . DS . $action . '.ctp');
                $contents = $file->read();
                break;
            }
        }
        
        if (!empty($contents)) {
            $this->set(compact('contents'));
            $this->set('saveRedirect', '/' . implode('/', func_get_args()));
            $this->set('page_title_for_layout', __('Edit <small>%s</small>', $controller . DS . $action . '.ctp'));
        } else {
            $this->Session->setFlash(__('No view file found.'));
            $this->redirect($this->referer());
        }
    }
    

    
/**
 * Reset method
 * 
 * Resets the view file to the default system view file.
 * 
 * @param string $plugin
 * @param string $controller
 * @param string $action
 */
    public function reset($plugin, $controller = null, $action = null) {
        if (empty($controller)) {
            $fix = explode('/', $plugin);
            $plugin = $fix[0];
            $controller = $fix[1];
            $action = !empty($this->request->params['named']['view']) ? $this->request->params['named']['view'] : $fix[2];
        }
        App::uses('Folder', 'Utility');
        App::uses('File', 'Utility');
        $plugin = Inflector::camelize($plugin);
        $controller = Inflector::camelize($controller);
        $action = !empty($this->request->params['named']['view']) ? $this->request->params['named']['view'] : $action; 
        $paths = App::path('View', $plugin);
        if (file_exists($paths[0] . $controller . DS . $action . '.ctp')) {
            // delete this file
            $file = new File($paths[0] . $controller . DS . $action . '.ctp');
            if ($file->delete()) {
                $this->Session->setFlash(__('File reset to original'));
                $this->redirect('/' . implode('/', func_get_args()));
            } else {
                $this->Session->setFlash(__('File reset failed'));
            }
        } else {
            $this->Session->setFlash(__('Custom view file not found'));
        }
        $this->redirect($this->referer());
    }
}