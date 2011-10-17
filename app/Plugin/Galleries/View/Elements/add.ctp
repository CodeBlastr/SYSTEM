<?php 
/**
 * Fields used when adding the first image to a gallery
 */
	echo $this->Form->input('GalleryImage.filename', array('type' => 'file', 'label' => 'Thumbnail'));
	echo $this->Form->input('GalleryImage.dir', array('type' => 'hidden'));
	echo $this->Form->input('GalleryImage.mimetype', array('type' => 'hidden'));
	echo $this->Form->input('GalleryImage.filesize', array('type' => 'hidden'));
?>