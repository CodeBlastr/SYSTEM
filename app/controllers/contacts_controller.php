<?php
class ContactsController extends AppController {

	var $name = 'Contacts';
	var $components = array('Email'); 

	function admin_index() {
		$this->Contact->recursive = 0;
		$this->set('contacts', $this->paginate());
	}

}
?>