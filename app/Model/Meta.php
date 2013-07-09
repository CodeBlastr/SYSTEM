<?php
App::uses('AppModel', 'Model');


class Meta extends AppModel {

	public $name = 'Meta';
	
	public $primaryKey = array('model', 'foreign_key');
}