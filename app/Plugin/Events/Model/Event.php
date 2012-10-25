<?php
App::uses('EventsAppModel', 'Events.Model');
/**
 * Event Model
 *
 * @property EventSchedule $EventSchedule
 * @property Creator $Creator
 * @property Modifier $Modifier
 * @property EventVenue $EventVenue
 * @property Guest $Guest
 */
class Event extends EventsAppModel {
    public $name = 'Event';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'event_schedule_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_public' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EventSchedule' => array(
			'className' => 'Events.EventSchedule',
			'foreignKey' => 'event_schedule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
//		'Creator' => array(
//			'className' => 'Users.Creator',
//			'foreignKey' => 'creator_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'Modifier' => array(
//			'className' => 'Users.Modifier',
//			'foreignKey' => 'modifier_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EventVenue' => array(
			'className' => 'Events.EventVenue',
			'foreignKey' => 'event_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Guest' => array(
			'className' => 'Events.EventsGuests',
			'joinTable' => 'events_guests',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
