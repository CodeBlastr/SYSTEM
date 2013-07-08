<?php 
echo $this->Form->create('', array('id' => 'updateForm')); 
echo $this->Form->hidden('Upgrade.all', array('value' => true)); 
echo $this->Form->submit('Check for Updates'); echo $this->Form->end(); 


echo $this->Form->create('', array('id' => 'updateForm')); 
echo $this->Form->hidden('Alias.update', array('value' => true)); 
echo $this->Form->submit('Sync Alias Table'); echo $this->Form->end(); 

for ($i = 0; $i < count($syncd); $i++) {
	echo __('<p>%s</p>', $syncd[$i]);
}

$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link('Admin Dashboard', '/admin'),
	'Updates'
	)))

?>