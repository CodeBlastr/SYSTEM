<?php
$items = array();
foreach($states as $state) {
	$items[$state['State']['id']] = $state['State']['name'];
}
echo $this->Js->object($items);
?>