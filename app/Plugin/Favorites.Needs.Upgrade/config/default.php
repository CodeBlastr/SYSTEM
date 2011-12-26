<?php 
$config['Favorites'] = array(
	'types' => array(
    	'favorite' => 'GalleryImage',
    	'wish' => 'GalleryImage',
        ),
	'defaultTexts' => array(
    	'favorite' => __('Favorite it', true),
    	'wish' => __('Add to Wish List', true),
		),
	'modelCategories' => array(
    	'GalleryImage'
        )
	);
?>