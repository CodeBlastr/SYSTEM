<?php
/**
 * Archivable Behavior
 * 
 * Adds an archive action button to view and edit ctp files, and a archived button to the index ctp files, and removes is_archived from the normal index.   It even adds the is_archived column to the table if it is not already an existing field. 
 */
class ArchivableBehavior extends ModelBehavior {

	var $allowDelete = true;
	var $tagName = 'Archive'; // Might also be called, Trash, Complete or anything else.
	var $unTagName = 'Unarchive'; // Might also be called, Trash, Complete or anything else.

	function setup(&$Model, $settings = array()) {
		debug($Model->name);
	}


	function beforeFind(&$Model, $queryData) {
		debug($Model->alias);
		debug($queryData);
	}
	
	
	/** 
	 * checks whether is_archived exists in the table, and if it doesn't creates the field
	 */
	function isTableValid(&$Model) {
	}
}

?>