<?php 
/**
 * Fields used when adding the first image to a gallery
 */
	echo $form->input('GalleryImage.filename', array('type' => 'file', 'label' => 'Thumbnail'));
	echo $form->input('GalleryImage.dir', array('type' => 'hidden'));
	echo $form->input('GalleryImage.mimetype', array('type' => 'hidden'));
	echo $form->input('GalleryImage.filesize', array('type' => 'hidden'));
?>