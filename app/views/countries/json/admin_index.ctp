<?php
$items = array();
foreach($countries as $country) {
	$items[$country['Country']['id']] = $country['Country']['name'];
}
echo $this->Js->object($items);
?>