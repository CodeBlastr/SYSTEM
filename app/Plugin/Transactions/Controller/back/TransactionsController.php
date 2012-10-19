<?php

App::uses('TransactionsAppController', 'Transactions.Controller');

/**
 * Transactions Controller
 *
 * All transactions should be pushed through this controller. It
 * is the catch all, and handles transaction types.
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
 * @link          http://zuha.com Zuha(tm) Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.transactions.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo	  Extend this controller by leaps and bounds to handle many transaction types and scenarios.
 */
class TransactionsController extends TransactionsAppController {


    public  $name = 'Transactions';
	    //$components = array('Ssl', 'Orders.Payments' /* , 'Shipping.Fedex' */),



    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
    }
    
}