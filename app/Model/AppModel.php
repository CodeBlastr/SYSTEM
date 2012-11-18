<?php
/**
 * App Wide Shared Model Functions
 *
 * Handles app wide model functions, model settings and convenience functions
 * all sub models use this model as the parent model
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
 * @subpackage    zuha.app.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */

App::uses('Model', 'Model');

class AppModel extends Model {

/**
 * Acts As
 *
 * @var array
 */
	public $actsAs = array('Containable');

/**
 * Recursive
 *
 * @var int
 */
  	public $recursive = -1;


/**
 * Manipulate data before it is saved.
 *
 * @todo    Move this record level access stuff to a behavior
 */
	public function beforeSave($model) {
	    // Start Record Level Access Save #
	    // If the model needs Record Level Access add an Aco
	    if (!empty($this->data['RecordLevelAccess']['UserRole'])) {
	    	// There may be a potential problem with this.
			// It saves an ArosAco record for every record being created.
	      	// For example, when creating a webpage, it also creates an Aco for the Alias
	      	// Left it in as is, because we may want this.  (ie. when a contact is record level,
	      	// we probably want the user to have access to the Contact and Contact Person
	      	// if a project issue is created, we probably want the user to have access to the project too.
      		$this->Behaviors->attach('Acl', array('type' => 'controlled'));
      		$this->Behaviors->attach('AclExtra', $this->data);
    	} else if (defined('__APP_RECORD_LEVEL_ACCESS_ENTITIES')){
      		if ($this->data['RecordLevelAccess'] = $this->_isRecordLevelRecord(__APP_RECORD_LEVEL_ACCESS_ENTITIES)) {
        		$this->Behaviors->attach('Acl', array('type' => 'controlled'));
        		$this->Behaviors->attach('AclExtra', $this->data);
      		}
    	}

    	// Start Auto Creator & Modifier Id Saving #
    	$exists = $this->exists();
    	$user = class_exists('CakeSession') ? CakeSession::read('Auth.User') : null;
    	if ( !$exists && $this->hasField('creator_id') && empty($this->data[$this->alias]['creator_id']) ) {
      		$this->data[$this->alias]['creator_id'] = $user['id'];
    	}
    	if ( $this->hasField('modifier_id') && empty($this->data[$this->alias]['modifier_id']) ) {
      		$this->data[$this->alias]['modifier_id'] = $user['id'];
    	}
    	// End Auto Creator & Modifier Id Saving #
		
		parent::beforeSave($model);
		
    	// you have to return true to make the save continue.
    	return true;
  	}


/**
 * Condition Check, checks to see if any conditions from the conditions table were met.
 */
	public function afterSave($created) {
	    // Start Condition Check #
    	$this->Condition = ClassRegistry::init('Condition');
	    //get the id that was just inserted so you can call back on it.
	    $this->data[$this->name]['id'] = $this->id;

	    if ($created === true) {
	    	$this->Condition->checkAndFire('is_create', array('model' => $this->name), $this->data);
	    } else {
	    	$this->Condition->checkAndFire('is_update', array('model' => $this->name), $this->data);
			#$this->conditionCheck('is_read'); // this needs to be put into the beforeFilter or beforeRender (beforeRender, would allow error pages to work too) of the
	    }
    	// End Condition Check #
		
		parent::afterSave($created);
	}


/**
 * Condition Check, checks to see if any conditions from the conditions table were met.
 */
	public function afterDelete() {
    	// Start Condition Check #
	    App::Import('Model', 'Condition');
	    $this->Condition = new Condition;
	    //get the id that was just inserted so you can call back on it.
	    $this->data[$this->name]['id'] = $this->id;
	    $this->Condition->checkAndFire('is_delete', array('model' => $this->name), $this->data);
	    // End Condition Check #
		
		parent::afterDelete();
	}



/**
 * With this function our total_count now appears with the rest of the fields in the resulting data array.
 * http://nuts-and-bolts-of-cakephp.com/2008/09/29/dealing-with-calculated-fields-in-cakephps-find/
 */
	public function afterFind($results, $primary = false) {
    	if($primary == true) {
        	if(Set::check($results, '0.0')) {
            	$fieldName = key($results[0][0]);
				foreach($results as $key=>$value) {
                	$results[$key][$this->alias][$fieldName] = $value[0][$fieldName];
	                unset($results[$key][0]);
	             }
			}
		}
		
		parent::afterFind($results, $primary);
		
		return $results;
	}


	public function listPlugins($remove = array(), $merge = true) {
	    $defaultRemove = array('Acl Extras', 'Api Generator', 'Recaptcha', 'Favorites.needs.upgrade', 'Forum.needs.upgrade');
	    $remove = !empty($merge) ? array_merge($defaultRemove, $remove) : $remove;
	    $plugins = CakePlugin::loaded();
	    foreach ($plugins as $plugin) :
			$return[$plugin] = Inflector::humanize(Inflector::underscore($plugin));
	    endforeach;

	    return array_diff($return, $remove);
	}


	public function listModels($pluginPath = null, $remove = array(), $merge = true) {
	    // defaultRemove originally done for this page : /admin/categories/categories/add/
	    // if you add items for removal from this list make sure that they should also be removed from there
	    // or customize the categories_controller so that listModels() function to not merge
	    $defaultRemove = array('Affiliated', 'Affiliates App Model', 'Alias', 'App Model', 'Authorize', 'Blogs App Model', 'Catalog Items Catalog Category', 'Catalogs App Model', 'Categories App Model', 'Categorized Option', 'Category', 'Categorized', 'Category Option', 'Catalog Item Price', 'Comments App Model', 'Condition', 'Contacts App Model', 'Contacts Contact', 'Coupons App Model', 'Credits App Model', 'Enumeration', 'Estimates App Model', 'Events App Model', 'Estimated', 'Form', 'Form Fieldset', 'Form Input', 'Forms App Model', 'Forum', 'Forum Category', 'Galleries App Model', 'Poll', 'Poll Option', 'Poll Vote', 'Post', 'Setting', 'Topic', 'Invite', 'Invite App Model', 'Invoices Catalog Item', 'Invoices App Model', 'Invoices Timesheet', 'Maps App Model', 'Media App Model', 'Members App Model', 'Menus App Model', 'Messages App Model', 'News App Model', 'Notifications App Model', 'Notification', 'Notification Template', 'Orders App Model', 'Favorite', 'Privilege', 'Privileges App Model', 'Project Issue', 'Projects.watcher', 'Projects App Model', 'Projects Member', 'Ratings App Model', 'Records App Model', 'Reports App Model', 'Requestor', 'Section', 'Search Index', 'Searchable App Model', 'Sitemaps App Model', 'Tags App Model', 'Tasks App Model', 'Tickets App Model', 'Ticket Departments Assignee', 'Timesheets Timesheet Time', 'Timesheets App Model', 'Used', 'User Role', 'Users App Model', 'Users User Group', 'Utils App Model', 'Webpages App Model', 'Wiki Content Version', 'Wikis App Model', 'Workflows App Model', 'Workflow', 'Workflow Item', 'Workflow Event', 'Workflow Item Event', 'Zencoder');
    	$remove = !empty($merge) ? array_merge($defaultRemove, $remove) : $remove;

	    $plugins = $this->listPlugins();

	    foreach ($plugins as $plugin) :
			$models = !empty($models) ? array_merge($models, App::objects($plugin . '.Model')) : App::objects($pluginPath . '.Model');
	    endforeach;

    	sort($models);
	    foreach ($models as $model) :
			$return[$model] = Inflector::humanize(Inflector::underscore($model));
	    endforeach;

    	return array_diff($return, $remove);
	}


/**
 * Don't know what this is for, I'd like to see a comment placed. OLD
 * Update... parentNode has something to do with ACL and how they are saved using the Behavior.  Not sure exactly how this one is used though.  1/2/2012 RK
 */
	public function parentNode() {
		$this->name;
	}


/**
 * Used to see whether the record being saved is a record which is subject to record level access control.  Executed in the beforeSave callback function of app_model.  If it is a record which is subject to record level access control, then beforeSave triggers the record level Aco and ArosAco creation.  Using the Acl behavior which make the Aco, and the AclExtra behavior which makes the AroAco using the user field which is supposed to get access as the Aro.  To set the Aros that should have access, make a setting called RECORD_LEVEL_ACCESS_ENTITY in the "settings" table of the database.
 *
 * @param {recordEntities}    An array of entities which should be subject to record level access control.
 * @return {array}        An array of user ids that should have access to the record.  (ie. assignee_id, user_id)
 * @todo            We could easily add UserRole to this array, and control group record level access for groups per save as well.  We would need to just add a model = key into the aro lookup in acl_extra as well.
 */
	private function _isRecordLevelRecord($recordEntities) {
	    # create the array
	    $data = $this->data;
	    $recordEntities = explode(',', $recordEntities);
	    foreach ($recordEntities as $recordEntity) {
	      $entities = explode('.', $recordEntity);
	      foreach ($entities as $entity) {
	        if (is_array($data) && array_key_exists($entity, $data)) {
	          $value = $data[$entity];
	          $data = $value;
	          if (!is_array($value)) {
	            $userIds[] = $value;
	          }
	        }
	      }
	    }

	    if (!empty($userIds)) {

	      return array('User' => $userIds);
	    } else {
	      return false;
		}
	}


/*
 * __uid
 * returns a 40 digit random key and adds the prefix if provided.
 * $table : array(Model => action)  if uniqueness is required across any table and column
 */
    public function __uuid($prefix = null, $table = null) {
        // creates a 6 digit key
        $uid = substr(md5(uniqid(rand(), true)), 0, 40);
        if ($prefix)
          $uid = $prefix . $uid;
        //checkto make sure its not a duplcate
        if ($table) {
        	foreach($table as $model => $col) {
            	$data = ClassRegistry::init($model)->find('first', array('conditions' => array($col => $uid)));
	            if (!empty($data)) {
        	        //if founds re-run the function
    	            $this->__uid($prefix, $table);
            	} else {
               		return $uid;
	            }
    		}
		} else {
			return $uid;
	    }
    }


    public function _generateUUID() {
        $uuid = $this->query('SELECT UUID() AS uuid');
        return $uuid[0][0]['uuid'];
    }

/**
 * Make sending email available to models (as well as controllers)
 *
 * @param string		String - address to send email to
 * @param sring			$subject: subject of email.
 * @param string		$message['html'] in the layout will be replaced with this text.
 * @param string		$template to be picked from folder for email. By default, if $mail is given in any template.
 * @param array			address/name pairs (e.g.: array(example@address.com => name, ...)
 * @param UNKNOWN		Have not used it don't know what it does or if it works.
 * @return bool
 */
	public function __sendMail($toEmail = null, $subject = null, $message = null, $template = 'default', $from = array(), $attachment = null) {
		App::uses('AppController', 'Controller');
		$Controller = new AppController;
		return $Controller->__sendMail($toEmail, $subject, $message, $template, $from, $attachment);
	}

}
