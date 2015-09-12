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
 * Recursive
 *
 * @var int
 */
  	public $recursive = -1;
	
/**
 * When finding with the Meta model, the conditions are removed beforeFind, and applied afterFind.
 * They are stored in this varialbe during that window.
 * 
 * @var boolean|array 
 */
	public $metaConditions = array();

/**
 * Theme
 *
 * @var array
 */
  	public $theme = array();

/**
 * Notifications
 * 
 * Used to supress notifications in the __sendMail() method by setting to false.
 *
 * @var array
 */
  	public $notifications = true;
	
/**
 * Permission Data
 *
 * @var array
 */
  	public $permissionData = array();
    
/**
 * Constructor
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$this->actsAs[] = 'Containable'; // moved here because it was being triggered too late 
		// Let's have a "global" variable for userId available to Models too
		$this->userId = (class_exists('CakeSession')) ? CakeSession::read('Auth.User.id') : null;
		parent::__construct($id, $table, $ds);
	}

/**
 * Manipulate data before it is saved.
 *
 * @todo    Move this record level access stuff to a behavior
 */
	public function beforeSave($options = array()) {
	    // Start Record Level Access Save
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
    	// End Auto Creator & Modifier Id Saving 

    	// you have to return true to make the save continue.
    	return parent::beforeSave($options);
  	}


/**
 * Condition Check, checks to see if any conditions from the conditions table were met.
 * 
 * This has been removed, because it should be in a behavior.  We won't use it until it has
 * been moved.  (Not every model should be "Conditionable" is the point.)
 * Same for afterDelete() 2/23/2012 RK
 
	public function afterSave($created) {
	    // Start Condition Check
    	$this->Condition = ClassRegistry::init('Condition');
	    //get the id that was just inserted so you can call back on it.
	    $this->data[$this->name]['id'] = $this->id;

	    if ($created === true) {
	    	$this->Condition->checkAndFire('is_create', array('model' => $this->name), $this->data);
	    } else {
	    	$this->Condition->checkAndFire('is_update', array('model' => $this->name), $this->data);
			#$this->conditionCheck('is_read'); // this needs to be put into the beforeFilter or beforeRender (beforeRender, would allow error pages to work too) of the
	    }
    	// End Condition Check
		
		parent::afterSave($created);
	}
 */


/**
 * Condition Check, checks to see if any conditions from the conditions table were met.
 * 
 * This has been removed, because it should be in a behavior.  We won't use it until it has
 * been moved.  (Not every model should be "Conditionable" is the point.)
 * Same for afterSave() 2/23/2012 RK
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
 */
	
/**
 * 
 * @param string $type
 * @param array $query
 */
	public function find($type = 'first', $query = array()) {
		$type = $this->_findType($type, $query);
		return parent::find($type, $query);
	}

/**
 * Find Type
 * Unfortunately, we cannot get the find() type from a behavior.
 * So we have to change the type here if it is a type of first.
 * That is because for the MetableBehavior to work we need more 
 * results (not less) in order to filter further as needed.
 * 
 * @param string $type
 * @return type
 */
	protected function _findType($type, $query) {
		$this->findType = $type; // we'll need this to reformat an all into a first data array format
		//$continue = isset($query['fields']) && strpos($query['fields'], '(') ? false : true; // don't do this if there is a function in the fields
		if((!isset($query['callbacks']) || (isset($query['callbacks']) && $query['callbacks'] !== false)) && is_a($this->Behaviors->Metable, 'MetableBehavior')) {
			$type = $type == 'first' ? 'all' : $type;
		}
		return $type;
	}



/**
 * After find callback
 * 
 * afterFind method
 */
	public function afterFind($results, $primary = false) {
		/* Deprecated : Not sure if removing broke anything 7/21/13 RK
 		// With this function our total_count now appears with the rest of the fields in the resulting data array.
		// http://nuts-and-bolts-of-cakephp.com/2008/09/29/dealing-with-calculated-fields-in-cakephps-find/
    	if($primary == true) {
        	if(Set::check($results, '0.0')) {
            	$fieldName = key($results[0][0]);
				foreach($results as $key=>$value) {
                	$results[$key][$this->alias][$fieldName] = $value[0][$fieldName];
	                unset($results[$key][0]);
	             }
			}
		} */
		
		// used so that the app controller can pass all data to elements and components in a consistent way
		//$this->data = !empty($this->data) ? $this->data : $results;

		// this solves some problems, like: not being able to use find('list')... but probably isn't a final solution.

		if (isset($results[$this->alias])) {
			$this->permissionData[0] = $results[$this->alias];
		} elseif (isset($results[0][$this->alias])) {
			$this->permissionData[0] = $results[0][$this->alias];
		} else {
			$this->permissionData = ( $this->findType == 'first' ) ? $results : null;
		}
		
		return $results;
	}


/**
 * Don't know what this is for, I'd like to see a comment placed. OLD
 * Update... parentNode has something to do with ACL and how they are saved using the Behavior.  Not sure exactly how this one is used though.  1/2/2012 RK
 * Update... parentNode() appears in the UserRole Model and is tied to the update of Aro records when a UserRole is created 7/21/2013 RK
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
	    // create the array
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
        if ($prefix) {
            $uid = $prefix . $uid;
        }
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
 * Subject and message have duel meanigns if it starts with webpages. we are using the db to genetrate the message were the subject is the recored we are using
 *
 * @param string		String - address to send email to
 * @param sring			$subject: subject of email |OR|  Webpage to use as a template (eg. Webpages.name-of-template)
 * @param string		$message['html'] in the layout will be replaced with this text |OR| data array available to use for message replacement 
 * @param string		$template to be picked from folder for email. By default, if $mail is given in any template.
 * @param array			address/name pairs (e.g.: array(example@address.com => name, ...)
 * @param UNKNOWN		Have not used it don't know what it does or if it works.
 * @return bool
 */
	public function __sendMail($toEmail = null, $subject = null, $message = null, $template = 'default', $from = array(), $attachment = null) {
		if ($this->notifications !== false) {
			App::uses('AppController', 'Controller');
			$Controller = new AppController;

			if (strpos($subject, 'Webpages.') === 0){
				$name = str_replace('Webpages.', '', $subject);
				App::uses('Webpage', 'Webpages.Model');
				$Webpage = new Webpage();
				$webpage = $Webpage->findByName($name);
				if (!empty($webpage)) {
					// $message should be something like this : array('SomeModel' => array('some_field' => 'some_value'));
					$message = $Webpage->replaceTokens($webpage['Webpage']['content'], $message);	
					$subject = $webpage['Webpage']['title'];
				} else {
					//Should we auto gen instead of throwing exception????
					throw new Exception(__('Please create a email template named %s', $name));
				}
			}

			return $Controller->__sendMail($toEmail, $subject, $message, $template, $from, $attachment);
		}
	}


/**
 * 
 */
	public function triggerOriginCallback($callbackName) {
		$args = func_get_args();
		unset($args[0]);
		if (!empty($callbackName) && $callbackName == 'origin_afterFind') {
			if (!empty($args[1][0][$this->alias]['model'])) { // results
				$models = array_unique(Set::extract('/' . $this->alias . '/model', $args[1]));
				if (!empty($models)) {
		            foreach ($models as $model) {
		            	if (!empty($model)) {
							$model = Inflector::classify($model);
			                App::uses($model, ZuhaInflector::pluginize($model).'.Model');
			                $Origin = new $model;
			                if (method_exists($Origin, 'origin_afterFind') && is_callable(array($Origin, 'origin_afterFind'))) {
			                    $args[1] = $Origin->origin_afterFind($this, $args[1], $args[2]);
			                }
		            	}
		            }
				}
			}
			return $args[1];
		}
		if (!empty($callbackName) && $callbackName == 'origin_afterSave') {
			$models = $args[1];
			$created = $args[2];
			if (!empty($models)) {
				foreach ($models as $model) {
		            if (!empty($model)) {
						$model = Inflector::classify($model);
						App::uses($model, ZuhaInflector::pluginize($model).'.Model');
						$Origin = new $model;
						if (method_exists($Origin, 'origin_afterSave') && is_callable(array($Origin, 'origin_afterSave'))) {
							$Origin->origin_afterSave($this, $created);
						}
					}
				}
			}
		}
		
	}
	
	/**
	 * Function to return a list of Associated Models keyed by Association type
	 */
	public function listAssociatedModels() {
		$result = array();
		foreach($this->associations() as $associated) {
			foreach($this->$associated as $assocModel => $assocConfig) {
				$result[] = $assocModel;
			}
		}
		return $result;
	}
	
	/**
	 * CSV Parsing Function used to create model and save imported models
	 */
	
	public function parsecsv($data=false, $deletefirst = true) {
		
		if(!isset($this->data[$this->alias]['uploadfile']) && !$data) {
			throw new Exception('No Data Defined', 0);
		}elseif(!isset($this->data[$this->alias]['uploadfile']) && $data) {
			$this->data = $data;
		}
		
		if($deletefirst) {
			$this->query("TRUNCATE {$this->table}");
		}
		// open the file
		$handle = fopen($this->data[$this->alias]['uploadfile']['tmp_name'], "r");
	
		// read the 1st row as headings
		$header = fgetcsv($handle);
		// create a message container
		$return = array(
				'messages' => array(),
				'errors' => array(),
		);
	
		// read each data row in the file
		while ( ($row = fgetcsv($handle)) !== FALSE ) {
			$i++;
			$csvData = array();
				
			// for each header field
			foreach ($header as $k => $head) {
				// get the data field from Model.field
				if (strpos($head, '.') !== false) {
					$h = explode('.', $head);
					$csvData[$h[0]][$h[1]] = (isset($row[$k])) ? $row[$k] : '';
				}
				// get the data field from field
				else {
					$csvData[$this->alias][$head] = (isset($row[$k])) ? $row[$k] : '';
					//$csvData[$this->alias]['owner_id'] = $data['Import']['owner_id'];
				}
			}
				
			// see if we have an id
			$id = isset($csvData[$this->alias]['id']) ? $csvData[$this->alias]['id'] : false;
	
			// we have an id, so we update
			if ($id) {
				$this->id = $id;
			}
	
			// or create a new record
			else {
				$this->create();
			}
	
			// see what we have
			
				
			// validate the row
			$this->set($csvData);
			if ( !$this->validates() ) {
				//$this->_flash( 'warning');
				$return['errors'][] = __(sprintf('Row %d failed to validate.', $i), true);
			}
			
			// save the row
			if ( !$this->save($csvData) ) {
				$return['errors'][] = __(sprintf('Row %d failed to save.', $i), true);
			}
			
			// success message!
			if ( !$error ) {
				$return['messages'][] = __(sprintf('Row %d was saved.', $i), true);
			}
		}
		
		// close the file
		fclose($handle);
		// return the messages
		return $return;
	}

/**
 * Sitemap method
 * Write the sitemap to the webroot folder
 */
	public function writeSitemap() {
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		$sitemap = array();
		$models = App::objects($plugin . '.Model');
		
		$plugins = CakePlugin::loaded();
	    foreach ($plugins as $plugin) {
	    	// the else here was App::objects($pluginPath . '.Model')  // not totally sure the changing to just plugin, won't break something
			$models = !empty($models) ? array_merge($models, App::objects($plugin . '.Model')) : App::objects($plugin . '.Model');
	    }
    	sort($models);
	    foreach ($models as $model) {
			strpos($model, 'AppModel') || strpos($model, 'AppModel') === 0 ? null : $return[$model] = $model;
	    }
		foreach (array_reverse($return) as $key => $model) {
			$model = ZuhaInflector::pluginize($model) ? ZuhaInflector::pluginize($model).'.'.$model : $model;
			try {
				$Model = ClassRegistry::init($model);
			} catch (Exception $e) {
				$Model = false;
				// ignore, we don't care about missing plugin exceptions here
				// debug($e->getMessage());
			}
			
			if( method_exists($Model,'sitemap') && is_callable(array($Model,'sitemap')) ) {
				$map = $Model->sitemap(); 
				$sitemap = is_array($map) ? array_merge($sitemap, $map) : $sitemap;
			}
		}
		
		// let's output the actual file here
		$path = ROOT . DS . SITE_DIR . DS . 'Locale' . DS .'View' . DS . 'webroot';
		
		$dir = new Folder($path);
		$file = new File($dir->pwd() . DS . 'sitemap.xml');
		
		$content = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
		foreach ($sitemap as $page) {
			$content .= "\t<url>" . PHP_EOL . "\t\t";
				$content .= '<loc>' . $page['url']['loc'] . '</loc>' . PHP_EOL . "\t\t";
				$content .= '<lastmod>' . $page['url']['lastmod'] . '</lastmod>' . PHP_EOL . "\t\t";
				$content .= '<changefreq>' . $page['url']['changefreq'] . '</changefreq>' . PHP_EOL . "\t\t";
				$content .= '<priority>' . $page['url']['priority'] . '</priority>' . PHP_EOL . "\t";
			$content .= '</url>' . PHP_EOL;
		}
		$content .= '</urlset>';
		if ($file->write($content)) {
			$file->close();
			return true;
		} else {
			return false;
		}
 	}

}
