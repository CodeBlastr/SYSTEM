<?php
class Setting extends AppModel {

	var $name = 'Setting';
	var $userField = array();
	
	// Used to define if this model requires record level user access control? 
	var $userLevel = false;
}
?>