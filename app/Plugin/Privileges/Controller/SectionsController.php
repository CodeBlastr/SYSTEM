<?php
/**
 * Sections Controller of Privileges Plugin
 *
 * Used for setting privileges across the entire site. 
 * Sections refer to the item being requested by a requestor. 
 * This might be a page or an action, or element, etc. 
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
 * @subpackage    zuha.app.plugins.privileges
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Just realized we 2 large updates for ACL still.  
 * @todo		  #1 We need to update the settings table records so that they include the action.  (Project.view.assignee_id)  Which will setup allowing ACL using those stinking _create, _read, _update, _delete fields.  Because right now, record level access control gives you access to all of the actions.  So we'll need that actionMap thing too, that I read a little about.  Basically another big pain.
 * @todo		  #2 We need to support HABTM tables for records which can have many users access them.  Ie. UserProfiles, Tickets (think department assignees), basically any model which doesn't belongsTo many.
 */
class SectionsController extends PrivilegesAppController {

	public $name = 'Sections';
	public $uses = 'Privileges.Section';
	
/**
 * Retrieves actions and controllers of a plugin
 * @param {int} $pid -> aco_id of the plugin
 * @return void
 */
	function index($pluginId = null){
		$sections = $this->Section->find('threaded', array(
			'conditions' => array(
				'parent_id NOT' => null,
                'alias NOT' => array('Install'), // admin user role only
				), 
			'contain' => array(
				'Requestor' => array(
					'fields' => array(
						'id'	
						)
					)
				),
			'order' => array('Section.lft ASC')	
		));
        
		//$parent = $this->Section->getParentNode($pluginId);
		//$this->set('userFields', $this->_userFields($parent, $sections));
		//$this->set('userFieldSettings', $this->_userFieldSettings($sections));
		//$this->set('parent', $this->Section->getParentNode($pluginId));
		$this->set('section', $sections[0]['Section']['alias']);
		unset($sections[0]);
		$this->set('sections', $sections);
		
		
		$this->Section->Requestor->bindModel(array(
			'belongsTo' => array(
				'UserRole' => array(
					'className' => 'Users.UserRole',
					'foreignKey' => 'foreign_key'))));
		
		$groups = $this->Section->Requestor->find('all' , array(
			'conditions' => array(
				'Requestor.model' => 'UserRole'
				),
			'contain'=>array(
				'UserRole'=>array(
					'fields'=>array(
						'name',
						'id'			
						)
					)
				)
			));
		
		$this->set('groups' , $groups);
        $this->set('page_title_for_layout', __('Manage Privileges'));
	}
	

/*
 * The form for adding an Section Manually. 
 * Added for not running users_controller/build_acl everytime.
 * 
 * @todo Can probably delete this now, as aco_sync should take care of it. 
 */
	public function add(){		
		App::import('Component', 'AclExtras.AclExtras');
		$AclExtras = new AclExtrasComponent;
		set_time_limit(1200);
		
		if(!empty($this->request->data)){
			if (!empty($this->request->data['Section']['controller'])) : 
				$AclExtras->aco_sync(array('controllers' => $this->request->data['Section']['controller']));
			elseif (!empty($this->request->data['Section']['plugin'])) :
				$AclExtras->aco_sync(array('plugins' => $this->request->data['Section']['plugin']));
			endif;
				
		} else {
			$AclExtras->aco_sync();
		}
		
		$message = '';
		foreach ($AclExtras->out as $out) :
			$message .= $out.'<br />';
		endforeach;
		
		$message = !empty($message) ? 'The following actions took place:<br />'.$message : 'Nothing to update.';
		$this->Session->setFlash($message);
		$this->redirect($this->referer());
	}
	
	
	protected function _userFields($parent, $data) {
		$plugin = $parent['Section']['alias'];
		$model = Inflector::classify($data[0]['Section']['alias']);
		$this->$model = ClassRegistry::init($plugin.'.'.$model);
		foreach ($this->$model->belongsTo as $belongModels) {
			foreach ($belongModels as $key => $value) {
				if ($key == 'className' && $value == 'User') {
					$userFields[] = $belongModels['foreignKey'];
				}
			}
		}
		if (!empty($userFields)) {
			return $userFields;
		} else {
			null;
		}
	}
	
	protected function _userFieldSettings($data) {
		if(defined('__APP_RECORD_LEVEL_ACCESS_ENTITIES')) {
			$recordEntities = explode(',', __APP_RECORD_LEVEL_ACCESS_ENTITIES);
			$model = Inflector::classify($data[0]['Section']['alias']);
			foreach ($recordEntities as $recordEntity) {
				$entities = explode('.', $recordEntity);
				if ($entities[0] == $model) {
					$setValues[] = $entities[1];
				}
			}
		}
		#pr($setValues);
	}
		

}
