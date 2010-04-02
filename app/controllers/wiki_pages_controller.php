<?php
class WikiPagesController extends AppController {

	var $name = 'WikiPages';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->WikiPage->recursive = 0;
		$this->set('wikiPages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid WikiPage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('wikiPage', $this->WikiPage->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->WikiPage->create();
			if ($this->WikiPage->save($this->data)) {
				$this->Session->setFlash(__('The WikiPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WikiPage could not be saved. Please, try again.', true));
			}
		}
		$media = $this->WikiPage->Media->find('list');
		$tags = $this->WikiPage->Tag->find('list');
		$wikis = $this->WikiPage->Wiki->find('list');
		$creators = $this->WikiPage->Creator->find('list');
		$modifiers = $this->WikiPage->Modifier->find('list');
		$this->set(compact('media', 'tags', 'wikis', 'creators', 'modifiers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid WikiPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->WikiPage->save($this->data)) {
				$this->Session->setFlash(__('The WikiPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WikiPage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->WikiPage->read(null, $id);
		}
		$media = $this->WikiPage->Media->find('list');
		$tags = $this->WikiPage->Tag->find('list');
		$wikis = $this->WikiPage->Wiki->find('list');
		$creators = $this->WikiPage->Creator->find('list');
		$modifiers = $this->WikiPage->Modifier->find('list');
		$this->set(compact('media','tags','wikis','creators','modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for WikiPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WikiPage->del($id)) {
			$this->Session->setFlash(__('WikiPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->WikiPage->recursive = 0;
		$this->set('wikiPages', $this->paginate());
	}

	/*function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid WikiPage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->WikiPage->contain('WikiContent');
		$this->set('wikiPage', $this->WikiPage->read(null, $id));
	}*/
	
	
	
	function admin_view($wiki = null, $title = null) {
		if(!$title) {
			$this->Session->setFlash('Invalid WikiPage.');
			#$this->redirect('/wiki_pages/index');
		}
		$this->WikiPage->contain('WikiContent');
		$wikiPage = $this->WikiPage->find('first', array('conditions' => array('title' => $title, 'wiki_id' => $wiki))); 
		if ($wikiPage) {
			$content = $wikiPage['WikiContent']['text'];

			$wikiPage['WikiContent']['text'] = '';
			$processMarkup = true;
			$processing = array(
				"&&&" => false, #<pre>
				"===" => false, #<h3>
				"'''" => false, #
				"!!!" => false,
				"___" => false,
				"[[[" => false,
				"]]]" => false,
				"*" => false,
				"#" => false,
			);
			$lines = explode("\n", $content);
			foreach ($lines as $line) {
				$line = trim($line);
				switch (substr($line, 0, 1)) {
					case "*" :
						if ($processMarkup) {
							if (!$processing["*"]) {
								$processing["*"] = true;
								$line = " <ul><li> " . substr($line, 1) . " </li> ";
							} else {
								$line = " <li> " . substr($line, 1) . " </li> ";
							}
						}
						break;
					case "#" :
						if ($processMarkup) {
							if (!$processing["#"]) {
								$processing["#"] = true;
								$line = " <ol><li> " . substr($line, 1) . " </li> ";
							} else {
								$line = " <li> " . substr($line, 1) . " </li> ";
							}
						}
						break;
					default :
						if ($processing["#"]) {
							$processing["#"] = false;
							$line = " </ol> " . $line;
						}
						if ($processing["*"]) {
							$processing["*"] = false;
							$line = " </ol> " . $line;
						}
						$line .= " <br /> ";
						break;
				}
				$words = explode(" ", $line);
				foreach ($words as $word) {
					$word = trim($word);
					switch (substr($word, 0, 3)) {
						case '&&&' :
							if ($processing["&&&"]) {
								$processing["&&&"] = false;
								$processMarkup = true;
								$word = '</pre>' . substr($word,3);
							} else {
								$processing["&&&"] = true;
								$processMarkup = false;
								$word = '<pre>' . substr($word,3);
							}
							break;
						case "===" :
							if ($processing["==="] && $processMarkup) {
								$processing["==="] = false;
								$word = '</h3>' . substr($word,3);
							} else {
								$processing["==="] = true;
								$word = '<h3>' . substr($word,3);
							}
							break;
						case "'''" :
							if ($processing["'''"] && $processMarkup) {
								$processing["'''"] = false;
								$word = '</i>' . substr($word,3);
							} else {
								$processing["'''"] = true;
								$word = '<i>' . substr($word,3);
							}
							break;
						case "!!!" :
							if ($processing["!!!"] && $processMarkup) {
								$processing["!!!"] = false;
								$word = '</b>' . substr($word,3);
							} else {
								$processing["!!!"] = true;
								$word = '<b>' . substr($word,3);
							}
							break;
						case "___" :
							if ($processing["___"] && $processMarkup) {
								$processing["___"] = false;
								$word = '</u>' . substr($word,3);
							} else {
								$processing["___"] = true;
								$word = '<u>' . substr($word,3);
							}
							break;
						case "[[[" :
							if ($processMarkup) {
								$processing["[[["] = true;
								$processing["]]]"] = substr($word,3);
								$word = substr($word,3);
							}
							break;
						case '---' :
							if ($processMarkup) {
								$word = '<hr />' . substr($word,3);
							}
							break;
						case 'htt' :
							if ($processMarkup && substr($word, 0,7) == "http://") {
								$word = "<a href='" . $word . "'>".$word."</a>";
							}
						default :
							if ($processMarkup) {
								if ($processing["]]]"] && substr($word, -3, 3) != "]]]") {
									$processing["]]]"] .= ' ' . $word;
									$word = '';
								}
								$processing["[[["] = false;
							}
					}
					switch (substr($word, -3, 3)) {
						case '&&&' :
							if ($processing["&&&"]) {
								$processing["&&&"] = false;
								$processMarkup = true;
								$word = substr($word,0,-3) . '</pre>';
							} else {
								$processing["&&&"] = true;
								$processMarkup = false;
								$word = substr($word,0,-3) . '<pre>';
							}
							break;
						case "===" :
							if ($processing["==="] && $processMarkup) {
								$processing["==="] = false;
								$word = substr($word,0,-3) . '</h3>';
							} else {
								$processing["==="] = true;
								$word = substr($word,0,-3) . '<h3>';
							}
							break;
						case "'''" :
							if ($processing["'''"] && $processMarkup) {
								$processing["'''"] = false;
								$word = substr($word,0,-3) . '</i>';
							} else {
								$processing["'''"] = true;
								$word = substr($word,0,-3) . '<i>';
							}
							break;
						case "!!!" :
							if ($processing["!!!"] && $processMarkup) {
								$processing["!!!"] = false;
								$word = substr($word,0,-3) . '</b>';
							} else {
								$processing["!!!"] = true;
								$word = substr($word,0,-3) . '<b>';
							}
							break;
						case "___" :
							if ($processing["___"] && $processMarkup) {
								$processing["___"] = false;
								$word = substr($word,0,-3) . '</u>';
							} else {
								$processing["___"] = true;
								$word = substr($word,0,-3) . '<u>';
							}
							break;
						case "[[[" :
							if ($processMarkup) {
								$processing["[[["] = true;
								$processing["]]]"] = substr($word,0,-3);
								$word = substr($word,0,-3);
							}
							break;
						case "]]]" :
							if ($processing["]]]"] && $processMarkup) {
								if (!$processing["[[["]) {
									$processing["]]]"] .= ' ' . substr($word,0,-3);
								} else {
									$processing["]]]"] = substr($processing["]]]"],0,-3);
								}
								if (strpos($processing["]]]"], "|")) {
									list($alink, $atitle) = explode('|', $processing["]]]"]);
								} else {
									$alink = $processing["]]]"];
									$atitle = false;
								}
								if (strpos($alink, "://")) {
									$word = "<a href='" . $alink . "'>";
								} else {
									# to do, make this more cakephpy
									#$word = $html->link(__('New Wiki Page', true), array('controller' => 'wiki_contents', 'action' => 'edit', $this->params['pass'][0]));
									
									
									$word = "<a href='/admin/wiki_pages/view/" .$this->params['pass'][0]."/". str_replace(" ", "_", $alink) ."'>";
								}
								if ($atitle) {
									$word .= $atitle;
								} else {
									$word .= $alink;
								}
								$word .= "</a>";
								$processing["[[["] = false;
								$processing["]]]"] = false;
							}
							break;
						case '---' :
							if ($processMarkup) {
								$word = substr($word,0,-3) . '<hr />';
							}
							break;
						default :
							if ($processMarkup && $processing[']]]']) {
								$word = '';
							}
							break;

					}
					$wikiPage['WikiContent']['text'] .= $word . ' ';
				}
			}
			$this->set('wikiPage', $wikiPage);
		} else {
			$this->redirect(array('controller' => 'wiki_contents', 'action' => 'add', $this->params['pass'][0], $this->params['pass'][1]));
		}
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->WikiPage->create();
			if ($this->WikiPage->save($this->data)) {
				$this->Session->setFlash(__('The WikiPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WikiPage could not be saved. Please, try again.', true));
			}
		}
		$media = $this->WikiPage->Media->find('list');
		$tags = $this->WikiPage->Tag->find('list');
		$wikis = $this->WikiPage->Wiki->find('list');
		$creators = $this->WikiPage->Creator->find('list');
		$modifiers = $this->WikiPage->Modifier->find('list');
		$this->set(compact('media', 'tags', 'wikis', 'creators', 'modifiers'));
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->WikiPage->save($this->data)) {
				$this->Session->setFlash(__('The WikiPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WikiPage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->WikiPage->contain('WikiContent');
			if (!empty($this->params['named']['wiki_page_id'])) {
				$this->data = $this->WikiPage->read(null, $this->params['named']['wiki_page_id']);
  		    } else { 
				$this->data = $this->WikiPage->read(null, $id);
			}
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for WikiPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WikiPage->del($id)) {
			$this->Session->setFlash(__('WikiPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>