<?php
class Setting extends AppModel {

	var $name = 'Setting';
	var $userField = array();
	
	// Does this model requires user level access
	var $userLevel = false;
}
?>