<?php
$items = array();
foreach($enumerationEssentials as $enumerationEssential) {
	$items[$enumerationEssential['EnumerationEssential']['id']] = $enumerationEssential['EnumerationEssential']['name'];
}
echo $javascript->object($items);
?>