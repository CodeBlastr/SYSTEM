<?php
App::uses('AppModel', 'Model');

class WebpagesAppModel extends AppModel {
			
/**
 * Template Directories
 */
 	public $templateDirectories = array();
			
/**
 * Css Directory
 */
 	public $cssDirectory = '';
			
/**
 * Js Directory
 */
 	public $jsDirectory = '';
	
/**
 * Constructor
 */
	public function __construct($id = false, $table = null, $ds = null) {		
		$this->templateDirectories = array(
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'Layouts'.DS, // must always come first (see saveTemplateFiles() for why)
			ROOT.DS.APP_DIR.DS.'Config'.DS.'Templates'.DS
		);
		
		$this->cssDirectory = ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'webroot'.DS.'css'.DS;
		
		$this->jsDirectory = ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'webroot'.DS.'js'.DS;
		
		$this->elementsDirectory = ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'Elements'.DS;
		
		parent::__construct($id, $table, $ds);
	}
	
/**
 * Sync Files
 * Check for templates, css, and js files and sync the database content fields
 *
 * @param string
 * @return bool
 * @todo This should only happen when there has been a change to the template
 */
	public function syncFiles($type = 'template') {
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		if ($type == 'template') {
			foreach($this->templateDirectories as $directory) {
				$dir = new Folder( $directory);
				$files = $dir->find('.*\.ctp');

                // This function must be responsible for making new template files show up at /webpages/index/template ^JB 6/3/2013
                if (!empty($files)) {
					$dbTemplates = $this->_getDbFileRecords($files, 'template');
					break; // stops us from searching in more directories
				}
			}
			
			if (!empty($files)) {
				foreach ($files as $file) {
					$file = new File($dir->pwd() . DS . $file);
					$templates[] = array('name' => $file->name, 'content' => $file->read(), 'type' => 'template', 'modified' => date('Y-m-d h:i:s', $file->lastChange()));
					// $file->write('I am overwriting the contents of this file');
					// $file->append('I am adding to the bottom of this file.');
					// $file->delete(); // I am deleting this file
					$file->close(); // Be sure to close the file when you're done
				}
			}
			
			foreach ($templates as $template) {
				$id = $this->find('first', array('conditions' => array('name' => $template['name']), 'fields' => array('id', 'modified'), 'callbacks' => false));
				if (!empty($id)) {
					if($id['Webpage']['modified'] < $template['modified']) {
						$this->id = $id['Webpage']['id'];
						try {
							$this->save($template);
						} catch (Exception $e) {
							throw new Exception ($e->getMessage());
						}
					}
				} else {
					try {
						$this->create();
						$this->save($template);
					} catch (Exception $e) {
						throw new Exception ($e->getMessage());
					}
				}
			}
		}	
		
		if ($type == 'css') {
			$dir = new Folder( $this->cssDirectory );
			$files = $dir->find('.*\.css');
			if (!empty($files)) {
				foreach ($files as $file) {
					$file = new File($dir->pwd() . DS . $file);
					$csses[] = array('name' => str_replace($this->cssDirectory, '', $file->path), 'content' => $file->read(), 'modified' => date('Y-m-d h:i:s', $file->lastChange()));
					$file->close(); // Be sure to close the file when you're done
				}
			}
			if (!empty($csses)) {
				foreach ($csses as $css) {
					$id = $this->field('id', array('WebpageCss.name' => $css['name']));
					if (!empty($id)) {
						try {
							$this->id = $id;
							$this->saveField('content', $css['content'], array('callbacks' => false));
						} catch (Exception $e) {
							debug($e->getMessage());
							break;
						}
					} else {
						try {
							$css['is_requested'] = 1;
							$this->create();
							$this->save($css);
						} catch (Exception $e) {
							debug($e->getMessage());
							break;
						}
					}
				}
			}
		}
		
		if ($type == 'js') {
			$dir = new Folder( $this->jsDirectory );
			$files = $dir->find('.*\.js');

			if (!empty($files)) {
				foreach ($files as $file) {
					$file = new File($dir->pwd() . DS . $file);
					$jses[] = array('name' => str_replace($this->jsDirectory, '', $file->path), 'content' => $file->read(), 'modified' => date('Y-m-d h:i:s', $file->lastChange()));
					$file->close(); // Be sure to close the file when you're done
				}
			}
			if (!empty($jses)) {
				foreach ($jses as $js) {
					$id = $this->field('id', array('WebpageJs.name' => $js['name']));
					if (!empty($id)) {
						try {
							$this->id = $id;
							$this->saveField('content', $js['content'], array('callbacks' => false));
						} catch (Exception $e) {
							debug($e->getMessage());
							break;
						}
					} else {
						try {
							$js['is_requested'] = 1;
							$this->create();
							$this->save($js);
						} catch (Exception $e) {
							debug($e->getMessage());
							break;
						}
					}
				}
			}
		}
		
		if ($type == 'element') {
			// not recursive into sub folders of the elements directory
			$dir = new Folder($this->elementsDirectory);
			$files = $dir->find('.*\.ctp');

			if (!empty($files)) {
				foreach ($files as $file) {
					$file = new File($dir->pwd() . DS . $file);
					$elements[] = array('name' => str_replace(array($this->elementsDirectory, '.ctp'), '', $file->path), 'content' => $file->read(), 'modified' => date('Y-m-d h:i:s', $file->lastChange()));
					$file->close(); // Be sure to close the file when you're done
				}
			}
			if (!empty($elements)) {
				foreach ($elements as $element) {			
					$id = $this->field('id', array('Webpage.name' => $element['name']));				
					if (!empty($id)) {
						try {
							$this->id = $id;
							$this->saveField('content', $element['content'], array('callbacks' => false));
						} catch (Exception $e) {
							debug($e->getMessage());
							break;
						}
					} else {
						try {
							$element['type'] = 'element';
							$this->create();
							$this->save($element);
						} catch (Exception $e) {
							debug($e->getMessage());
							break;
						}
					}
				}
			}
		}
	}

/**
 * Get templates from the database with matching names
 *
 * @param array
 * @param string
 * @return array
 */
 	protected function _getDbFileRecords($files = null, $type = 'template') {			
		if ($type == 'css') {
			$dbTemplates = $this->find('all', array(
				'conditions' => array(
					'WebpageCss.name' => $files
					)
				));
		} else if ($type == 'js') {
			$dbTemplates = $this->find('all', array(
				'conditions' => array(
					'WebpageJs.name' => $files
					)
				));
		} else {
			$dbTemplates = $this->find('all', array(
				'conditions' => array(
					'Webpage.name' => $files
					),
				'callbacks' => false
				));
		}
		return $dbTemplates;
	}

}