<?php
/** 
 * CMS Webpage Model.
 * Handles the cms data 
 *
 * @todo		Need to add custom validation for webpage types.  (like is_default and template_urls can't both have values)
 */
class Webpage extends WebpagesAppModel {
	
	public $name = 'Webpage';
	public $displayField = 'name';
	public $validate = array(
		'name' => array('notempty'),
	);

	public $fullName = "Webpages.Webpage";

	public $hasOne = array(
		'Alias' => array(
			'className' => 'Alias',
			'foreignKey' => 'value',
			'dependent' => true,
			'conditions' => array('controller' => 'webpages'),
			'fields' => '',
			'order' => ''
		),
	);

	public $belongsTo = array(
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
    public $filterArgs = array(
        array('name' => 'name', 'type' => 'like'),
        #array('name' => 'search', 'type' => 'like', 'field' => 'Webpage.description'),
        #array('name' => 'range', 'type' => 'expression', 'method' => 'makeRangeCondition', 'field' => 'Webpage.views BETWEEN ? AND ?'),
        #array('name' => 'username', 'type' => 'like', 'field' => 'User.username'),
        #array('name' => 'tags', 'type' => 'subquery', 'method' => 'findByTags', 'field' => 'Article.id'),
        array('name' => 'filter', 'type' => 'query', 'method' => 'orConditions'),
    );

/* Part of the search plugin testing.  Apparently you can use functions to conduct some search customization like the commented out versions above.  Find info here : https://github.com/CakeDC/search
    function findByTags($data = array()) {
        $this->Tagged->Behaviors->attach('Containable', array('autoFields' => false));
        $this->Tagged->Behaviors->attach('Search.Searchable');
        $query = $this->Tagged->getQuery('all', array(
            'conditions' => array('Tag.name'  => $data['tags']),
            'fields' => array('foreign_key'),
            'contain' => array('Tag')
        ));
        return $query;
    }
*/
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		if (in_array('Search', CakePlugin::loaded())) : 
			$this->actsAs[] = 'Search.Searchable';
		endif;
	}

	public function afterDelete() {
		# delete template settings
		$this->_saveTemplateSettings($this->id, null, true);
	}

    public function orConditions($data = array()) {
        $filter = $data['filter'];
		debug($filter);
        $cond = array(
            'OR' => array(
                $this->alias . '.name LIKE' => '%' . $filter . '%',
                $this->alias . '.content LIKE' => '%' . $filter . '%',
				$this->alias . '.type' => $filter,
            ));
        return $cond;
    }
	
	
	public function add($data = array()) {
		$data = $this->cleanInputData($data);
		# save webpage first
		if ($this->saveAll($data)) {
			$pageId = $this->id;
			# template settings are special
			if ($data['Webpage']['type'] == 'template' && $this->_saveTemplateSettings($pageId, $data)) {
				# do nothing we may want to attach behaviors still
				# the return true happens outside of these ifs
			} 
			return true;
		} else {
			throw new Exception(__d('webpages', 'Save failed.', true));
		}
		/* Revisit this because I could not find where the function is, and it could be made better 
		with having it possible to restrict user roles or available to only certain user roles
		# if permissions are set, restrict them
		if (!empty($this->request->data['ArosAco']['aro_id'])) {
			$this->__restrictGroupPermissions($acoParent, $this->Webpage->id, $this->request->data['ArosAco']['aro_id'], true);
		}
		*/
	}	
	
	public function update($data = array()) {
		$data = $this->cleanInputData($data);
		# save webpage first
		if ($this->saveAll($data)) {
			$pageId = $this->id;
			# template settings are special
			if ($data['Webpage']['type'] == 'template' && $this->_saveTemplateSettings($pageId, $data)) {
				# do nothing we may want to attach behaviors still
				# the return true happens outside of these ifs
			}
			return true;
		} else {
			throw new Exception(__d('webpages', 'Save failed.', true));
		}
		/* Revisit this because I could not find where the function is, and it could be made better 
		with having it possible to restrict user roles or available to only certain user roles
		# if permissions are set, restrict them
		if (!empty($this->request->data['ArosAco']['aro_id'])) {
			$this->__restrictGroupPermissions($acoParent, $this->Webpage->id, $this->request->data['ArosAco']['aro_id'], true);
		}
		*/
	}
	
/**
 * When a page is a template we have to save the settings for that template, so that Zuha knows when to show it.
 *
 *@param {int}			The id of the page we're making settings for
 *@param {array}		An array of data to get the template, and template settings from
 */
	private function _saveTemplateSettings($pageId, $data = null, $delete = false) {
		if(!empty($data)) {
			$settingsArray = array(
				'templateId' => $pageId,
				'isDefault' => $data['Webpage']['is_default'],
				'urls' => '"'.$data['Webpage']['template_urls'].'"',
				'userRoles' => $data['Webpage']['user_roles'],
				);
		}
			
		extract(unserialize(__APP_TEMPLATES));
		$template[$pageId] = base64_encode(gzcompress(serialize($settingsArray)));
			
		$data['Setting']['value'] = '';
		$data['Setting']['type'] = 'App';
		$data['Setting']['name'] = 'TEMPLATES';
		foreach ($template as $key => $value) :
			# merge existing values here
			if ($delete && $key == $pageId) {
				# doing nothing should removee the value from the settings
			} else {
				$data['Setting']['value'] .= 'template['.$key.'] = "'.$value.'"'.PHP_EOL;
			}
		endforeach;
		
		$this->Setting = ClassRegistry::init('Setting');
		if ($this->Setting->add($data)) {
			return true;
		} else {
			return false;
		}
	}
		
	
	public function parseIncludedPages(&$webpage, $parents = array (), $action = 'page', $userRoleId = null) {
		$matches = array ();
		$parents[] = $webpage['Webpage']['id'];
		preg_match_all ("/(\{page:([^\}\{]*)([0-9]*)([^\}\{]*)\})/", $webpage["Webpage"]["content"], $matches);
		for ($i = 0; $i < sizeof ($matches[2]); $i++) {
			if (in_array ($matches[2][$i], $parents)) {
				$webpage["Webpage"]["content"] = str_replace($matches[0][$i], "", $webpage['Webpage']['content']);
				continue;
			}
            switch ($action) {
                case 'site_edit':
                    $include_container = array('start' => '<div contenteditable="false" id="edit_webpage_include'.$matches[2][$i].'" pageid="'.trim($matches[2][$i]).'" class="global_edit_area">', 'end' => '</div>');
                break;
                default:
                    $include_container = array('start' => '<div id="edit_webpage_include'.trim($matches[2][$i]).'" pageid="'.trim($matches[2][$i]).'" class="global_edit_area">', 'end' => '</div>');
            }
			
			// remove the div.global_edit_area's if this user is not userRoleId = 1
			if($userRoleId !== '1') $include_container = array('start' => '', 'end' => '');

			$webpage2 = $this->find("first", array("conditions" => array( "id" => trim($matches[2][$i])) ) );		
			if(empty($webpage2) || !is_array($webpage2)) continue;
			$this->parseIncludedPages ($webpage2, $parents, $action, $userRoleId);
			if ($webpage['Webpage']['type'] == 'template') :
				$webpage["Webpage"]["content"] = str_replace ($matches[0][$i], $include_container['start'].$webpage2["Webpage"]["content"].$include_container['end'], $webpage["Webpage"]["content"]);
			else :
				$webpage["Webpage"]["content"] = str_replace ($matches[0][$i], $webpage2["Webpage"]["content"], $webpage["Webpage"]["content"]);
			endif;
			#$webpage['Webpage']['content'] = '<div id="webpage_content" pageid="'.$id.'">'.$webpage['Webpage']['content'].'</div>';
		}
	}
	
	public function types() {
		return array('template' => 'Template', 'element' => 'Element', 'page_content' => 'Page');
	}
	
/**
 * @todo		 Clean out alias data for templates and elements.
 */
	public function cleanInputData($data) {
		if (!empty($data['Webpage']['user_roles']) && is_array($data['Webpage']['user_roles'])) :
			# serialize user roles
			$data['Webpage']['user_roles'] = serialize($data['Webpage']['user_roles']);
		endif;
		
		if (!empty($data['Webpage']['template_urls'])) :
			# cleaning the string for common user entry differences
			$urls = str_replace(PHP_EOL, ',', $data['Webpage']['template_urls']);
			$urls = str_replace(' ', '', $urls);
			$urls = explode(',', $urls);
			foreach ($urls as $url) : 
				$url = str_replace('/*', '*', $url);
				$url = str_replace(' ', '', $url);
				$url = str_replace(',/', ',', $url);
				$out[] = strpos($url, '/') == 0 ? substr($url, 1) : $url;
			endforeach;
			$data['Webpage']['template_urls'] = base64_encode(gzcompress(serialize($urls)));
		endif;		
		
		if (empty($data['Alias']['name'])) :
			# remove the alias if the name is blank
			unset($data['Alias']);
		endif;	
		
		return $data;
	}
	
	
/**
 * @todo		 Clean out alias data for templates and elements.
 */
	public function cleanOutputData($data) {
		if (!empty($data['Webpage']['user_roles'])) :
			$data['Webpage']['user_roles'] = unserialize($data['Webpage']['user_roles']);
		endif;
		
		if (!empty($data['Webpage']['template_urls'])) :
			$data['Webpage']['template_urls'] = implode(PHP_EOL, unserialize(gzuncompress(base64_decode($data['Webpage']['template_urls']))));
		endif;		
		
		return $data;
	}
	
	
	public function handleError($webpage, $request) {
		$userRole = CakeSession::read('Auth.User.user_role_id');
		$addLink = $userRole == 1 ? '<p class="message">Page Not Found : <a href="/webpages/webpages/add/alias:' . $_GET['referer'] . '"> Click here to add a page at http://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['referer'] . '</a>. <br /><br /><small>Because you are the admin you can add the page you requested.  After you add the page http://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['referer'] . ' you can visit it again and it will be a working page.</small></p>' : '';
		$webpage['Webpage']['content'] = $addLink . $webpage['Webpage']['content'];
		return $webpage;
	}
	
	private function _addPage() {
		return 'addition';
	}
	
}
?>