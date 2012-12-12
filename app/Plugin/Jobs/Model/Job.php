<?php
App::uses('JobsAppModel', 'Jobs.Model');
/**
 * Job Model
 *
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
 * @link          http://zuha.com Zuha� Ticket
 * @package       zuha
 * @subpackage    zuha.app.plugins.tickets.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class Job extends JobsAppModel {

public $name = 'Job';

public $actsAs = array(
        'Metable',
        );

/**
 * Construct
 *
 * @return null
 */
    public function __construct($id = false, $table = null, $ds = null) {

           
        if (in_array('Estimates', CakePlugin::loaded())) {
            $this->hasMany['Estimate'] = array(
                'className' => 'Estimates.Estimate',
                'foreignKey' => 'foreign_key',
                'dependent' => true,
                'conditions' => array('Estimate.model' => 'Contact'),
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            );
        }
       if (in_array('Categories', CakePlugin::loaded())) {
          
            $this->hasAndBelongsToMany['Category'] = array(
                'className' => 'Categories.Category',
                  'joinTable' => 'categorized',
                'foreignKey' => 'foreign_key',
                'associationForeignKey' => 'category_id',
                'conditions' => 'Categorized.model = "Job"',
                // 'unique' => true,
                );
             $this->hasMany['CategorizedOption'] = array(
                'className' => 'Categories.CategorizedOption',
                   'joinTable' => 'categorized_options',
                'foreignKey' => 'foreign_key',
                'associationForeignKey' => 'category_option_id',
                //'unique' => true,
                );    
           $this->actsAs['Categories.Categorizable'] = array('modelAlias' => 'Job');  
        } 
            
        parent::__construct($id, $table, $ds);
        $this->order = array("{$this->alias}.title");
  } 
 /**
 * Before Save method
 * 
 * @param type $options
 * @return boolean
 */
    public function beforeSave($options) {
        $this->Behaviors->attach('Galleries.Mediable'); // attaching the gallery behavior here, because the ProductParent was causing a problem making $Model->alias = 'ProductParent', in the behavior.
        $this->data = $this->_cleanAddData($this->data);
        return true;
    }
    
 /**
 * Cleans data for adding
 *
 * @access protected
 * @param array
 * @return array
 */
     protected function _cleanAddData($data) {
        
        if (!empty($data['Job']['arb_settings'])) {
            // serialize the data
            $data['Job']['arb_settings'] = serialize($this->data['Job']['arb_settings']);
        }

        if(!empty($data['Job']['payment_type'])) {
            $data['Job']['payment_type'] = implode(',', $this->data['Job']['payment_type']);
        }

        if (empty($data['Job']['sku'])) {
            // generate random sku if none exists
            $data['Job']['sku'] = rand(10000, 99000);
        }
        
        return $data;
    }    
  
 /**
 * Payment Options
 *
 * @access public
 * @param void
 * @return string
 */
    public function paymentOptions() {
        if(defined('__ORDERS_ENABLE_SINGLE_PAYMENT_TYPE') && defined('__ORDERS_ENABLE_PAYMENT_OPTIONS')) {
            return unserialize(__ORDERS_ENABLE_PAYMENT_OPTIONS);
        } else {
            return null;
        }
    }
     /**
     * This trims an object, formats it's values if you need to, and returns the data to be merged with the Transaction data.
     * @param string $key
     * @return array The necessary fields to add a Transaction Item
     */
    public function mapTransactionItem($key) {
        
        $itemData = $this->find('first', array('conditions' => array('id' => $key)));
        
        $fieldsToCopyDirectly = array(
        'name',
        'weight',
        'height',
        'width',
        'length',
        'shipping_type',
        'shipping_charge',
        'payment_type',
        'arb_settings',
        'is_virtual'
        );
        
        foreach($itemData['Job'] as $k => $v) {
        if(in_array($k, $fieldsToCopyDirectly)) {
            $return['TransactionItem'][$k] = $v;
        }
        }
        
        //$itemData['TransactionItem'] = $itemData['Product'];
        
        //unset($itemData['Product']);
        return $return;
    }
}