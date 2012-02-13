<?php
echo $this->Element('scaffolds/index', array(
	'data' => $galleries, 
	'actions' => false/*array(
		$this->Html->link('View', array('action' => 'view', '{model}', '{foreign_key}')), 
		$this->Html->link('Edit', array('action' => 'edit', '{model}', '{foreign_key}')), 
		$this->Html->link('Delete', array('action' => 'delete', '{id}'), array(), 'Are you sure you want to permanently delete?'),
		),*/
	)); ?>