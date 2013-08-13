<?php 
class ClassifiedsSchema extends CakeSchema {

	public $renames = array();

	public function __construct($options = array()) {
		parent::__construct();
	}

	public function before($event = array()) {
		App::uses('UpdateSchema', 'Model'); 
		$this->UpdateSchema = new UpdateSchema;
		$before = $this->UpdateSchema->before($event);
		return $before;
	}

	public function after($event = array()) {
		$this->UpdateSchema->rename($event, $this->renames);
		$this->UpdateSchema->after($event);
	}

	public $classifieds = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'title' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Title of Item', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Description', 'charset' => 'latin1'),
		'condition' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Item Condition', 'charset' => 'latin1'),
		'payment_terms' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Payment Terms', 'charset' => 'latin1'),
		'shipping_terms' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Shipping Terms', 'charset' => 'latin1'),
		'price' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'city' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'city', 'charset' => 'latin1'),
		'state' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'state', 'charset' => 'latin1'),
		'zip' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'zip code', 'charset' => 'latin1'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'Weight of ad, used for levels of premium'),
		'posted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'Posted Date'),
		'expire_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'Expiration Date'),
		'creator_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'Creator', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'Created Date'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'Modified Date'),
		'data' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Data Column', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
}
