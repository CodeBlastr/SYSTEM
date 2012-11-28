<?php
echo $this->Element('scaffolds/index', array('data' => $aliases, 'actions' => array(
    $this->Html->link('Edit', array('plugin' => null, 'controller' => 'aliases', 'action' => 'edit', '{id}'))
)));