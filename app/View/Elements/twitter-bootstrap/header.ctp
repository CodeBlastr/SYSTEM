<?php 
if ($this->Session->read('Auth.User')) {
    echo $this->Element('header', array('showContext' => true));
} ?>