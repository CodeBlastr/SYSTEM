<?PHP
class Video extends AppModel {
	
	
	public $name = 'Video';
	
	
	public $belongsTo = array(
		'User' => array(
			'foreignKey' => 'user_id'
		)
	);
	
	
}//class{}