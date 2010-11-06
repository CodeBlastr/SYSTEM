<?php
class Setting extends AppModel {

	var $name = 'Setting';
	var $userField = array(); # Used to define the creator table field (typically creator_id)
	var $userLevel = false; # Used to define if this model requires record level user access control?
	
}
?>