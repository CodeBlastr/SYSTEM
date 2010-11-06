<?php
class Tag extends AppModel {

	var $name = 'Tag';
	var $validate = array(
		'name' => array('notempty')
	);
	var $userField = array();
	
	// Used to define if this model requires record level user access control? 
	var $userLevel = false;

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'TagParent' => array(
			'className' => 'Tag',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function addTagCountGetIds($tagData = null) {
		# when you're done move this to the Tags model
		
		/* its probably quicker to grab all of the tags and 
		array search them, than to do a query for each tag, 
		plus it allows us to do case in-senstive searches */
		$tags = $this->find('all', array('conditions' => array('type' => $tagData['type'])));
		
		#prepare tags for searching
		foreach ($tags as $key => $tag) {
			$names[$tag['Tag']['id']] = strtolower($tag['Tag']['name']);
		}
		
		$tagNames = explode(',',  $tagData['name']);
		foreach ($tagNames as $key => $tagName) {
			#prepare $tagNames for searching
			$tagName = trim($tagName);
			$tagNameLower = strtolower($tagName);			
			if (array_search($tagNameLower, $names)) {
				#return the tag id if it exists
				$tagId = array_search($tagNameLower, $names);
				$tagIds[] = $tagId;
				$updateTag = $this->find('first', array('conditions' => array('id' => $tagId)));
				$this->data['Tag']['id'] = $tagId;
				$this->data['Tag']['count'] = $updateTag['Tag']['count'] + 1;
				if ($this->save($this->data)) {
				} 
			} else {
				#otherwise create a tag and return that id
				$this->data['Tag']['type'] = $tagData['type'];
				$this->data['Tag']['name'] = $tagName;	
				$this->data['Tag']['count'] = 1;
				if ($this->save($this->data)) {
					$tagIds[] = $this->id;
					#set to null so you can create multiple
					$this->id = null;
				} 
			}
		}
		# to do : need to handle tag removal in some way too
		return $tagIds;
	}

}
?>