<?php

// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 9.0.0

class ShippingComponent extends Object {

	var $request = array(
			'WebAuthenticationDetail' => array('UserCredential' => array('Key' => 'BWw8o4cRu1z7NZZU', 'Password' => 'CjV3icwSEDDpgFiTFweIkaEAc')), 
			'ClientDetail' => array('AccountNumber' => '510087585', 'MeterNumber' => '100061554'),
			'TransactionDetail' => array('CustomerTransactionId' => ' *** Rate Request v9 using PHP ***'),
			'Version' => array('ServiceId' => 'crs', 'Major' => '9', 'Intermediate' => '0', 'Minor' => '0'),
			'ReturnTransitAndCommit' => true,
			'RequestedShipment' => array(
				'DropoffType' => 'REGULAR_PICKUP' ,	// valid values REGULAR_PICKUP, REQUEST_COURIER, ...
				//'ShipTimestamp' => date('c') ,
				'ServiceType' => 'FEDEX_GROUND', //'INTERNATIONAL_PRIORITY' ,	// valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
				'PackagingType' => 'YOUR_PACKAGING' ,	// valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
				'TotalInsuredValue' => array('Ammount'=>100,'Currency'=>'USD') ,
				'Shipper' => array('Address' => array('StateOrProvinceCode' => 'CA',
										  			'PostalCode' => '95451',
										  			'CountryCode' => 'US')
										  		),
				'Recipient' => array(
							'Address' => array(
							'StreetLines' => array('Address Line 1'),
							'City' => 'Richmond',
							'StateOrProvinceCode' => 'NY',
							'PostalCode' => '10002',
							'CountryCode' => 'US',
							'Residential' => '')
						),
				'ShippingChargesPayment' => array('PaymentType' => 'SENDER'),
				'RateRequestTypes' => 'ACCOUNT', 
				'RateRequestTypes' => 'LIST', 
				'PackageCount' => '2',
				'PackageDetail' => 'INDIVIDUAL_PACKAGES',  //  Or PACKAGE_SUMMARY
				'RequestedPackageLineItems' => array('0' => array('Weight' => array('Value' => 2.0,
																	'Units' => 'LB'),
																	'Dimensions' => array('Length' => '',
																	'Width' => '',
																	'Height' => '',
																	'Units' => 'IN')),
											 		)
												)); 

	function getRate($data=null) {
		$this->request = array_merge((array)$this->request, (array)$data);
		$newline = "<br />";
		$path_to_wsdl = dirname(__FILE__)."/../../config/Rate.wsdl";
		ini_set("soap.wsdl_cache_enabled", "0");
		
		$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
		
		try 
		{
			if($this->setEndpoint('changeEndpoint'))
			{
				$newLocation = $client->__setLocation($this->setEndpoint('endpoint'));
			}
		
			$response = $client->getRates($this->request);
		
			if ($response -> HighestSeverity !=	'FAILURE' && $response -> HighestSeverity != 'ERROR')
			{  	
				$rateReply = $response -> RateReplyDetails;
				$freight['amount'] = number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") ;			
			}
			else
			{
				$freight['Message'] = $response->Notifications->Message;
			} 
			
			$this->writeToLog($client);	// Write to log file   
		} catch (SoapFault $exception) {
		   $freight['Message'] = $exception->faultstring;
		}
		return $freight;
	}
	
	/**
	 * SOAP request/response logging to a file
	 */								  
	function writeToLog($client){
		define('TRANSACTIONS_LOG_FILE', dirname(__FILE__).'/../../log/fedextransactions.log');  // Transactions log file  
		if (!$logfile = fopen(TRANSACTIONS_LOG_FILE, "a"))
		{
		   error_func("Cannot open " . TRANSACTIONS_LOG_FILE . " file.\n", 0);
		   exit(1);
		}
	
		fwrite($logfile, sprintf("\r%s:- %s",date("D M j G:i:s T Y"), $client->__getLastRequest(). "\n\n" . $client->__getLastResponse()));
	}
	
	
	function setEndpoint($var){
		if($var ==		'changeEndpoint') Return false;
		if($var ==		'endpoint') Return		'XXX';
	}
	
}
?>
