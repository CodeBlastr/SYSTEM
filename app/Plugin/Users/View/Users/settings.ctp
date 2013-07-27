
<h4>The emails that will be sent to user registrations.</h4>
<p>Available tags : none</p>
<?php
echo $this->Form->create('Setting', array('url' => array('plugin' => null, 'controller' => 'settings', 'action' => 'add')));
echo $this->Form->input('Override.redirect', array('type' => 'hidden', 'value' => '/admin/users/users/settings'));
echo $this->Form->input('Setting.type', array('type' => 'hidden', 'value' => 'Users'));
echo $this->Form->input('Setting.name', array('type' => 'hidden', 'value' => 'EMAILS'));
foreach ($methods as $method) {
	echo $this->Form->input('Setting.value.'.$method.'.subject', array('label' => __('%s Subject', Inflector::humanize(Inflector::underscore($method)))));
	echo $this->Form->input('Setting.value.'.$method.'.body', array('type' => 'richtext', 'label' => false));
	echo '<hr />';
}
echo $this->Form->end('Save'); ?>