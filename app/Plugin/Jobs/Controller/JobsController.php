<?php
App::uses('JobsAppController', 'Jobs.Controller');

/**
 * Jobs Controller
 *
 * This class will act as the adding Coupon codes for products discount. 
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
 * @subpackage    zuha.app.plugins.tickets
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class JobsController extends JobsAppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Jobs';

	public $uses = 'Jobs.Job';
    

     /**
     * This is a function to Lists all the posted jobs
     * 
     * @version 1.0
     * @name index
     * @access public
     * @return void
     */
     
	public function index() {   
        
      $this->paginate = array('order' => array('id' => 'asc'),'limit' => 10);  
      $jobs = $this->paginate('Job');    // set Pagination
      $this->set(compact('jobs')); 
      //Set Page Title 
      $this->set('page_title_for_layout', __('Lists Jobs')); 
      //Set Title for Layout
      $this->set('title_for_layout', __('Lists Jobs Code'));   	
	}
    
     /**
     * This is a function to Lists the Jobs posted by logged user.
     * 
     * @version 1.0
     * @name my
     * @access public
     * @return void
     */
    public function my() {   
        
      $creator_id=$this->Session->read('Auth.User.id');
        
      $conditions = array('Job.creator_id' => $creator_id);                                                                             
      $this->paginate = array('conditions' => $conditions,'order' => array('id' => 'asc'),'limit' => 10);  
      $jobs = $this->paginate('Job');  // set Pagination   
      $this->set(compact('jobs')); 
      $this->set('page_title_for_layout', __('Lists Jobs')); 
      $this->set('title_for_layout', __('Lists Jobs Code'));       
    }
    
    /**
     * This is a function to Add the Job
     * 
     * @version 1.0
     * @name add
     * @access public
     * @return redirect my Page   
     */
    public function add() {
  
        if (!empty($this->request->data)) {
            try {
                $this->request->data['Job']['owner_id']=$this->Session->read('Auth.User.id');    // Set Login Session as customer id     
                $this->request->data['Job']['creator_id']=$this->Session->read('Auth.User.id'); 
                $this->request->data['Job']['modifier_id']=$this->Session->read('Auth.User.id');
                $this->Job->save($this->request->data); 
                $this->Session->setFlash(__('Job saved.', true));
                $this->redirect(array('action' => 'my'));
            } catch (Exception $e) {
                $this->Session->setFlash(__('Job could not be saved.'));
            }
        }
        
       if (in_array('Categories', CakePlugin::loaded())) {
            $this->set('categories', $this->Job->Category->generateTreeList());
        }  
        
       $this->set('page_title_for_layout', __('Create a Job'));  
       $this->set('title_for_layout', __('Add Job')); 
    }
    
   /**
     * This is a function to Update the Jobs 
     * 
     * @version 1.0
     * @name edit
     * @access public
     * @return redirect my Page   
     */
    public function edit($id=null) {

       if (!empty($this->request->data)) {
           
            try {
                $this->request->data['Job']['owner_id']=$this->Session->read('Auth.User.id');    // Set Login Session as customer id     
                $this->request->data['Job']['creator_id']=$this->Session->read('Auth.User.id'); 
                $this->request->data['Job']['modifier_id']=$this->Session->read('Auth.User.id');
                $id=$this->request->data['Job']['id']; 
                $this->Job->save($this->request->data); 
                $this->Session->setFlash(__('Job saved.', true));
                $this->redirect(array('action' => 'my'));
            } catch (Exception $e) {
                $this->Session->setFlash(__('Job could not be saved.'));
            }
        }
     
        $this->set('categories', $this->Job->Category->generateTreeList());
         
        
        $this->request->data = $this->Job->read(null, $id); 
        
        $this->set('page_title_for_layout', __('Update a Job'));  
        $this->set('title_for_layout', __('Update Job')); 
    } 
    
     /**
     * This is a function to Delete the Jobs Code
     * 
     * @version 1.0
     * @name jobsdelete
     * @access public
     * @return redirect my Page   
     */ 
    
     public function jobsdelete($id=null) { 
         
         $jobs = $this->paginate('Job');
         $this->Job->delete($id);
         $this->Session->setFlash(__('Job was deleted.', true));
         $this->redirect(array('action' => 'my'));
     }
                                                      
    /**
    * View method
    * 
    * @param type $id
    * @throws NotFoundException
    */
    public function view($id = null) {
        $this->Job->id = $id;
        if (!$this->Job->exists()) {
            throw new NotFoundException(__('Job not found'));
        }
        
        $job = $this->Job->findById($id); 
        $this->set(compact('job')); 
        
        // vars for opportunities
        unset($this->paginate);
        $this->paginate = array('fields' => array('Estimate.id', 'Estimate.name', 'Estimate.created', 'Estimate.creator_id', 'Creator.id', 'Creator.full_name'), 'contain' => array('Creator'));
        $this->set('estimates', in_array('Estimates', CakePlugin::loaded()) ? $this->paginate('Job.Estimate', array('Estimate.foreign_key' => $id, 'Estimate.model' => 'Job')) : null);
    } 
    
    /**
    * estimates method
    * 
    * @param tyte $id
    * @throws NotFoundException
    */
    public function estimates($id = null) {
        $this->Job->id = $id;
        if (!$this->Job->exists()) {
            throw new NotFoundException(__('Job not found'));
        }
        
        $job = $this->Job->findById($id); 
        $this->set(compact('job')); 
        
        // vars for opportunities
        unset($this->paginate);
        $this->paginate = array('fields' => array('Estimate.id', 'Estimate.name', 'Estimate.total','Estimate.created', 'Estimate.creator_id', 'Creator.id', 'Creator.full_name'), 'contain' => array('Creator'));
        $this->set('estimates', in_array('Estimates', CakePlugin::loaded()) ? $this->paginate('Job.Estimate', array('Estimate.foreign_key' => $id, 'Estimate.model' => 'Job')) : null);
    }   
     
    /**
    * Add an opportunity / estimate for a contact
    */
    public function estimate($jobId = null) {
        $this->Job->id = $jobId;
        if (!$this->Job->exists()) {
            throw new NotFoundException(__('Job not found'));
        }
        $job = $this->Job->read(null, $jobId);
        if (!empty($this->request->data)) {
            try {
                
                $this->request->data['Estimate']['recipient_id']=$job['Job']['creator_id'];
                $this->request->data['Estimate']['creator_id']=$this->Session->read('Auth.User.id');
                $this->request->data['Estimate']['modifier_id']=$this->Session->read('Auth.User.id');
                
                $this->Job->Estimate->save($this->request->data);
                $this->Session->setFlash('Bid Added');
                $this->redirect(array('action' => 'view', $jobId));
            } catch (Exception $e) {
                $this->Session->setFlash($e->getMessage());            
            }
        }
        
        $this->set(compact('job')); 
        $this->set('page_title_for_layout', __('Create an bid for %s', $job['Job']['title']));
    }
    
     /**
     * This is a function for get job categories
     *                                 
     * @version 1.0
     * @name get_categories
     * @access public
     */ 
    
    function get_categories($job_id = null) {
      App::Import('Model', 'Categories.Categorized') ;
      $Categorized = new Categorized();
      $categories = $Categorized->find('all', array('conditions'=> array('foreign_key' => $job_id,'Model' => 'Job')));  
      
          
      App::Import('Model', 'Categories.Category') ;
      $Category = new Category();
       
      foreach($categories as $val) {
         $categories_name = $Category->findAllById($val['Categorized']['category_id']);
         
         foreach($categories_name as $category_name) { 
           $get_category_name = $category_name['Category']['name'].','.$get_category_name;
         }
      }
      
      
      $get_category_name = substr($get_category_name,0,-1); 
      
      return $get_category_name;
      
    }
     
        
    
}