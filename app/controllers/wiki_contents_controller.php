<?php
class WikiContentsController extends AppController {

	var $name = 'WikiContents';
	var $helpers = array('Wikiparser');

	function index() {
		$this->WikiContent->recursive = 0;
		$this->set('wikiContents', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid WikiContent.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('wikiContent', $this->WikiContent->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->WikiContent->create();
			if ($this->WikiContent->save($this->data)) {
				$this->Session->setFlash(__('The WikiContent has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WikiContent could not be saved. Please, try again.', true));
			}
		}
		$wikiPages = $this->WikiContent->WikiPage->find('list');
		$creators = $this->WikiContent->Creator->find('list');
		$modifiers = $this->WikiContent->Modifier->find('list');
		$this->set(compact('wikiPages', 'creators', 'modifiers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid WikiContent', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->WikiContent->save($this->data)) {
				$this->Session->setFlash(__('The WikiContent has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WikiContent could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->WikiContent->read(null, $id);
		}
		$wikiPages = $this->WikiContent->WikiPage->find('list');
		$creators = $this->WikiContent->Creator->find('list');
		$modifiers = $this->WikiContent->Modifier->find('list');
		$this->set(compact('wikiPages','creators','modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for WikiContent', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WikiContent->del($id)) {
			$this->Session->setFlash(__('WikiContent deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->WikiContent->recursive = 0;
		$this->set('wikiContents', $this->paginate());
	}


	function admin_view($id = null, $title = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid WikiContent.', true));
			$this->redirect(array('action'=>'index'));
		} else { 
			$this->WikiContent->contain('WikiPage');
			$wikiPage =  $this->WikiContent->WikiPage->find('first', array('conditions' => array('wiki_id' => $id, 'title' => $title)));
			$wikiContent = $this->WikiContent->find('first', array('conditions' => array('wiki_page_id' => $wikiPage['WikiPage']['id'])));
			if(!empty($wikiContent)) {
				$this->set('wikiContent', $wikiContent);
			} else {
				$this->Session->setFlash(__('WikiContent does not exist. Create?', true));
				$this->redirect(array('controller' => 'wiki_contents', 'action'=>'edit', $id, $title));
			}
		}
	}

	function admin_add() {
		if (!empty($this->data)) {
			# import the necessary models
			App::import('Model', 'Wiki, WikiPage, WikiContent, WikiContentVersion');
			$this->Wiki = new Wiki();	
			$this->WikiPage = new WikiPage();	
			$this->WikiContent = new WikiContent();
			$this->WikiContentVersion = new WikiContentVersion();
			App::import('Model', 'ProjectsWiki');
			$this->ProjectsWiki = new ProjectsWiki();
			# if the wiki page does not exist
			if(empty($this->data['WikiPage']['id']) && empty($this->data['WikiPage']['wiki_id'])) {
				# create the wiki page first if it doesn't exist
				$this->WikiPage->create();
				if ($this->WikiPage->save($this->data)) {
					$wikiPage = $this->WikiPage->find('first', array('conditions' => array('title' => $this->data['WikiPage']['title'], 'wiki_id' => 0))); 
					$this->data['Wiki']['wiki_page_id'] = $wikiPage['WikiPage']['id'];
					$this->data['WikiPage'] = $wikiPage['WikiPage'];
					# create the wiki 
					$this->Wiki->create(); 
					if ($this->Wiki->save($this->data)) {
						# update the wiki page with the wiki id
						$wiki = $this->Wiki->find('first', array('conditions' => array('wiki_page_id ' => $this->data['Wiki']['wiki_page_id'])));
						$this->data['WikiPage']['wiki_id'] = $wiki['Wiki']['id'];
						if ($this->WikiPage->save($this->data)) {
							# save the wiki contents
							if (empty($this->data['WikiContent']['version'])) : $this->data['WikiContent']['version'] = 1; endif;
							$this->data['WikiContent']['wiki_page_id'] = $wikiPage['WikiPage']['id'];
							$this->WikiContent->create(); 
							if ($this->WikiContent->save($this->data)) {
								#save the wiki content version
								$this->data['WikiContentVersion'] = $this->data['WikiContent'];
								$this->WikiContentVersion->create(); 
								if ($this->WikiContentVersion->save($this->data)) {
									# now save the project wiki relationship
									$this->data['ProjectsWiki']['wiki_id'] = $this->data['WikiPage']['wiki_id'];
									$this->ProjectsWiki->create();  
									if ($this->ProjectsWiki->save($this->data)) {
										$this->Session->setFlash(__('The Wiki has been saved', true));
										$this->redirect(array('controller' => 'wiki_pages', 'action'=>'view', $this->data['WikiPage']['wiki_id'], $this->data['WikiPage']['title'] ));
									}
								}
							}
						}
					}
				}
			} 
			#if the wiki does exist and the page does or doesn't
			if(!empty($this->data) && !empty($this->data['WikiPage']['wiki_id'])) {
				$this->WikiPage->create();
				if ($this->WikiPage->save($this->data)) {
					$wikiPageId = $this->WikiPage->find('first', array('conditions' => array('title' => $this->data['WikiPage']['title'], 'wiki_id' => $this->data['WikiPage']['wiki_id']))); 
					#set the page id for a new wiki page
					$this->data['WikiContent']['wiki_page_id'] = $wikiPageId['WikiPage']['id'];
					$this->data['WikiContentVersion']['wiki_page_id'] = $wikiPageId['WikiPage']['id'];
				} else {
					$this->Session->setFlash(__('The WikiContent could not be saved. Please, try again.', true));
				}
				# up the version number by one
				$this->data['WikiContent']['version'] = $this->data['WikiContent']['version'] + 1;
				# set the version save data
				$this->data['WikiContentVersion'] = $this->data['WikiContent'];
				# remove the id from version so that it creates a new record
				$this->data['WikiContentVersion']['id'] = '';
				# perform the save
				if ($this->WikiContent->save($this->data)) {
				# save to the version table as well for calling previous versions
					$this->WikiContentVersion->create();
					if ($this->WikiContentVersion->save($this->data)) {
						$this->Session->setFlash(__('The WikiContent has been saved', true));
						$this->redirect(array('controller' => 'wiki_contents', 'action'=>'view', $this->data['WikiPage']['wiki_id'], $this->data['WikiPage']['title'] ));
					}
				} else {
					$this->Session->setFlash(__('The WikiContent could not be saved. Please, try again.', true));
				}
	        }
		}
	}

	function admin_edit($id = null, $title = null) {
		if (!empty($this->data)) {
			# import the necessary models
			App::import('Model', 'Wiki, WikiPage, WikiContent, WikiContentVersion');
			$this->Wiki = new Wiki();	
			$this->WikiPage = new WikiPage();	
			$this->WikiContent = new WikiContent();
			$this->WikiContentVersion = new WikiContentVersion();
			App::import('Model', 'ProjectsWiki');
			$this->ProjectsWiki = new ProjectsWiki();
			# if the wiki page does not exist
			if(empty($this->data['WikiPage']['id']) && empty($this->data['WikiPage']['wiki_id'])) {
				# create the wiki page first if it doesn't exist
				$this->WikiPage->create();
				if ($this->WikiPage->save($this->data)) {
					$wikiPage = $this->WikiPage->find('first', array('conditions' => array('title' => $this->data['WikiPage']['title'], 'wiki_id' => 0))); 
					$this->data['Wiki']['wiki_page_id'] = $wikiPage['WikiPage']['id'];
					$this->data['WikiPage'] = $wikiPage['WikiPage'];
					# create the wiki 
					$this->Wiki->create(); 
					if ($this->Wiki->save($this->data)) {
						# update the wiki page with the wiki id
						$wiki = $this->Wiki->find('first', array('conditions' => array('wiki_page_id ' => $this->data['Wiki']['wiki_page_id'])));
						$this->data['WikiPage']['wiki_id'] = $wiki['Wiki']['id'];
						if ($this->WikiPage->save($this->data)) {
							# save the wiki contents
							if (empty($this->data['WikiContent']['version'])) : $this->data['WikiContent']['version'] = 1; endif;
							$this->data['WikiContent']['wiki_page_id'] = $wikiPage['WikiPage']['id'];
							$this->WikiContent->create(); 
							if ($this->WikiContent->save($this->data)) {
								#save the wiki content version
								$this->data['WikiContentVersion'] = $this->data['WikiContent'];
								$this->WikiContentVersion->create(); 
								if ($this->WikiContentVersion->save($this->data)) {
									# now save the project wiki relationship
									$this->data['ProjectsWiki']['wiki_id'] = $this->data['WikiPage']['wiki_id'];
									$this->ProjectsWiki->create();  
									if ($this->ProjectsWiki->save($this->data)) {
										$this->Session->setFlash(__('The Wiki has been saved', true));
										$this->redirect(array('controller' => 'wiki_pages', 'action'=>'view', $this->data['WikiPage']['wiki_id'], $this->data['WikiPage']['title'] ));
									}
								}
							}
						}
					}
				}
			}
			#if the wiki does exist and the page does or doesn't
			if(!empty($this->data) && !empty($this->data['WikiPage']['wiki_id'])) {
				$this->WikiPage->create();
				if ($this->WikiPage->save($this->data)) {
					$wikiPageId = $this->WikiPage->find('first', array('conditions' => array('title' => $this->data['WikiPage']['title'], 'wiki_id' => $this->data['WikiPage']['wiki_id']))); 
					#set the page id for a new wiki page
					$this->data['WikiContent']['wiki_page_id'] = $wikiPageId['WikiPage']['id'];
					$this->data['WikiContentVersion']['wiki_page_id'] = $wikiPageId['WikiPage']['id'];
				} else {
					$this->Session->setFlash(__('The WikiContent could not be saved. Please, try again.', true));
				}
				# up the version number by one
				$this->data['WikiContent']['version'] = $this->data['WikiContent']['version'] + 1;
				# set the version save data
				$this->data['WikiContentVersion'] = $this->data['WikiContent'];
				# remove the id from version so that it creates a new record
				$this->data['WikiContentVersion']['id'] = '';
				# perform the save
				if ($this->WikiContent->save($this->data)) {
				# save to the version table as well for calling previous versions
					$this->WikiContentVersion->create();
					if ($this->WikiContentVersion->save($this->data)) {
						$this->Session->setFlash(__('The WikiContent has been saved', true));
						$this->redirect(array('controller' => 'wiki_contents', 'action'=>'view', $this->data['WikiPage']['wiki_id'], $this->data['WikiPage']['title'] ));
					}
				} else {
					$this->Session->setFlash(__('The WikiContent Version could not be saved. Please, try again.', true));
				}
	        }
		}
		if (empty($this->data)) {
			$this->WikiContent->contain('WikiPage');
			if (!empty($this->params['named']['wiki_page_id'])) {
				$this->data = $this->WikiContent->find('first', array('wiki_page_id' => $this->params['named']['wiki_page_id']));
  		    } else { 
				$this->WikiContent->contain('WikiPage');
				$wikiPage =  $this->WikiContent->WikiPage->find('first', array('conditions' => array('wiki_id' => $id, 'title' => $title)));
				$this->data = $this->WikiContent->find('first', array('conditions' => array('wiki_page_id' => $wikiPage['WikiPage']['id'])));
			}
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for WikiContent', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WikiContent->del($id)) {
			$this->Session->setFlash(__('WikiContent deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>