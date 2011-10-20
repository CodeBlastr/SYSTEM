<?php
$items = array();
foreach($enumerations as $enumeration) {
	$items[$enumeration['Enumeration']['id']] = $enumeration['Enumeration']['name'];
}
echo $this->Js->object($items);
?>