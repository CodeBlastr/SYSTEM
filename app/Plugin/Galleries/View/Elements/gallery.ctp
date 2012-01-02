<?php
# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_GALLERIES_GALLERY_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_GALLERIES_GALLERY_'.$instance)));
} else if (defined('__ELEMENT_GALLERIES_GALLERY')) {
	extract(unserialize(__ELEMENT_GALLERIES_GALLERY));
}

if (!empty($model) && !empty($foreignKey)) {
	# make a request action to pull the gallery data
	$gallery = $this->requestAction("/galleries/galleries/view/{$model}/{$foreignKey}"); 
	if (!empty($gallery)) {
		echo $this->Element($gallery['GallerySettings']['galleryType'], array('gallery' => $gallery), array('plugin' => 'galleries'));
	} else {
		# do nothing so so that other pages can test for null in the html of this gallery (like catalog items view does)
	}
} else {
	echo __('Gallery model and foreignKey were not provided (Galleries/View/Elements/gallery.ctp)');
}