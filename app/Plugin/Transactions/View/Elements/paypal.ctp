<?php 
	$options = array('Visa' => 'Visa', 'MasterCard' => 'MasterCard');
	echo 'Credit Card Type: <br />';
	echo $this->Form->select('credit_type', $options);
?>