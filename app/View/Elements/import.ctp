<?php
echo $this->Html->tag('p', 'Multiple items may be imported at once using a <abbr title="A CSV is a file of Comma-Separated Values, and can be easily created from any spreadsheet program.">CSV</abbr> file.');
echo $this->Html->tag('p', $this->Html->link('Download a sample template', '/'.$this->request->params['plugin'].'/import-sample.csv') );

echo $this->Form->create('Import', array(
	'type' => 'file',
	'url' => $this->Html->url( array(
		'plugin' => $this->request->params['controller'],
		'controller' => $this->request->params['plugin'],
		'action'=>'import'
	) )
));

// hidden if there is one possible Owner of these imported items,
// dropdown if there is an array of possible Owners
if ( !is_array($ownerId) ) {
	echo $this->Form->hidden('owner_id', array('value' => $ownerId));
} else {
	echo $this->Form->select('owner_id', $ownerId, array('empty' => 'Select Event Owner'));
}

echo $this->Form->file('csv', array('label' => false));
echo $this->Form->submit('Upload & Import');
echo $this->Form->end();

//debug($this);