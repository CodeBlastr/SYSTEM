<?php

/**
 * Payment Gateways integrated 
 */
class PaymentsComponent extends Object {

    var $paysettings = array();
    var $response = array();
    var $paymentComponent = null;
    var $Controller = null;
    var $recurring = false;

    function initialize() {
	
    }

    function beforeRender() {
	
    }

    function beforeRedirect() {
	
    }

    function shutdown() {
	
    }

    // class variables go here 
    function startup(&$controller) {
	$this->Controller = $controller;
	// This method takes a reference to the controller which is loading it. 
	// Perform controller initialization here. 
    }

    // set recurring value default is false
    function recurring($val = false) {
	$this->recurring = $val;
    }

    function loadComponent($components = array()) {

	foreach ((array) $components as $component => $config) {
	    if (is_int($component)) {
		$component = $config;
		$config = null;
	    }
	    list($plugin, $componentName) = pluginSplit($component);
	    if (isset($this->Controller->{$componentName})) {
		continue;
	    }

	    $component = 'Transactions.' . $component;

	    App::import('Component', $component);
	    $componentFullName = $componentName . 'Component';
	    $component = new $componentFullName($config);

	    if (method_exists($component, 'initialize')) {
		$component->initialize($this->Controller);
	    }
	    if (method_exists($component, 'startup')) {
		$component->startup($this->Controller);
	    }
	    $this->paymentComponent = $component;
	}
    }

    /**
     * Payment by chargin CC based on Authorize.net
     *
     * data is the combination of CC information, shipping and billing
     * Returns the response. If response_code is 1 then the transaction was successful
     * All the details in reason_text and description.
     */
    function Pay($data = null) {
	$paymentProcessor = ucfirst(strtolower($data['Transaction']['mode']));
	$paymentProcessor = explode('.', $paymentProcessor);
	$paymentProcessor = $paymentProcessor[0];
	
	$this->loadComponent($paymentProcessor);
	if ($this->recurring) {
	    $this->paymentComponent->recurring(true);
	    $this->paymentComponent->Pay($data);
	} else {
	    $this->paymentComponent->Pay($data);
	}

	return $this->paymentComponent->response;
    }

    /*
     * function changeSubscription() use to change the recurring profile status
     * profileId: id of recurrence, can be profile id of payer
     * action: suspended or cancelled
     */

    function ManageRecurringPaymentsProfileStatus($data = null) {

	$this->loadComponent(ucfirst(strtolower($data['Mode'])));
	$this->paymentComponent->ManageRecurringPaymentsProfileStatus($data['profileId'], $data['action']);

	return $this->paymentComponent->response;
    }

}