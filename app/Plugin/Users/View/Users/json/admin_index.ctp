<?php
$items = array();
foreach($users as $user) {
	$items[$user['User']['id']] = $user['User']['username'];
}
echo $this->Js->object($items);
?>