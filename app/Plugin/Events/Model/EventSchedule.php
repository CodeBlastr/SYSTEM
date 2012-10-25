<?php
App::uses('EventsAppModel', 'Events.Model');
/**
 * EventSchedule Model
 *
 * @property Type $Type
 * @property Creator $Creator
 * @property Modifier $Modifier
 * @property Event $Event
 */
class EventSchedule extends EventsAppModel {
    public $name = 'EventSchedule';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
//	public $belongsTo = array(
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
//	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Event' => array(
			'className' => 'Events.Event',
			'foreignKey' => 'event_schedule_id',
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

}
