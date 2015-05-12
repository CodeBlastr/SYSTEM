<?php 
if ($this->Session->read('Auth.User')) {
    echo $this->element('header', array('showContext' => true));
} ?>