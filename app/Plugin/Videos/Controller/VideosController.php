<?PHP
class VideosController extends AppController {
	
	
	var $name = 'Videos';
	var $uid;
	var $uses = array('zencoder_source');
	var $allowedActions = array('view', 'notification');
	
	
	/*
	*	show an admin index or the videos of the current user?
	*/
	public function index() {
		
	}//index()
	
	
	public function upload() {
		
		if($this->data){
			// verify & process an upload
			if($this->data['Video']['submittedfile']) {
				
			} elseif($this->data['Video']['submittedurl']) {
				
			} else {
				$this->flash(__('Invalid Upload.', true), array('action'=>'index'));	
			}
		}
		
	}//upload()
	
	
	public function view($videoID = null) {
		
		if($videoID) {
			$the_video = $this->Video->findById($videoID);
			$this->set('the_video', $the_video);
		}
		
	}//view()
	
	
	public function notification($outputID = null) {
		
		if($outputID) {
			// zencoder is notifying us that a Job is complete
			if($this->data['output']['state'] == 'finished') {
				
				echo "w00t!\n";
				
				// If you're encoding to multiple outputs and only care when all of the outputs are finished
				// you can check if the entire job is finished.
				if($this->data['job']['state'] == 'finished') {
					echo "Dubble w00t!\n";
				}
				
			} elseif($this->data['output']['state'] == 'cancelled') {
				echo "Cancelled!\n";
			} else {
				echo "Fail!\n";
				debug($this->data);
				echo $this->data['output']['error_message']."\n";
				echo $this->data['output']['error_link'];
			}
		}//if($outputID)
		
	}//notification()
	
	
}//class{}