<?php 
/**
 * Gallery Thumb Element
 *
 * Displays the thumb nail image for a gallery.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.galleries.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
if (!empty($model) && !empty($foreignKey)) {
	$galleryThumb = $this->requestAction("/galleries/galleries/thumb/{$model}/{$foreignKey}");
} else {
    $model = 'Gallery';
}
 
// set up the config vars
$thumbLink = !empty($thumbLink) ? $thumbLink : null;
$thumbSize = !empty($thumbSize) ? $thumbSize : 'small';
// default sizes
$galleryThumb['GallerySettings'][$thumbSize.'ImageWidth'] = !empty($galleryThumb['GallerySettings'][$thumbSize.'ImageWidth']) ? $galleryThumb['GallerySettings'][$thumbSize.'ImageWidth'] : 24;
$galleryThumb['GallerySettings'][$thumbSize.'ImageHeight'] = !empty($galleryThumb['GallerySettings'][$thumbSize.'ImageHeight']) ? $galleryThumb['GallerySettings'][$thumbSize.'ImageHeight'] : 24;
// get width from settings table
$indexWidth = !empty($galleryThumb['GallerySettings']['indexImageWidth']) ? $galleryThumb['GallerySettings']['indexImageWidth'] : $galleryThumb['GallerySettings'][$thumbSize.'ImageWidth'];
$indexHeight = !empty($galleryThumb['GallerySettings']['indexImageHeight']) ? $galleryThumb['GallerySettings']['indexImageHeight'] : $galleryThumb['GallerySettings'][$thumbSize.'ImageHeight'];
// if the width was defined in the element call
$thumbWidth = !empty($thumbWidth) ? array('width' => $thumbWidth) : array('width' => $indexWidth);
$thumbHeight = !empty($thumbHeight) ? array('height' => $thumbHeight) : array('height' => $indexHeight);
$thumbAlt = !empty($thumbAlt) ? array('alt' => $thumbAlt) : array('alt' => $model);
$thumbClass = !empty($thumbClass) ? array('class' => $thumbClass) : array('class' => 'thumbnail gallery-thumb');
$thumbId = !empty($thumbId) ? array('id' => $thumbId) : array('id' => 'gallery'.$foreignKey); // was $galleryThumb['Gallery']['id'] (didn't work for /cart)
$thumbImageOptions = array_merge($thumbWidth, $thumbHeight, $thumbAlt, $thumbClass, $thumbId);
$thumbDiv = isset($thumbDiv) ? ($thumbDiv==true ? true : false) : true; // added to skip the display of div on demand (true/false)
$thumbLinkOptions = !empty($thumbLinkOptions) ? array_merge($thumbClass, $thumbId, $thumbLinkOptions, array('escape' => false)) : array('escape' => false);
$thumbLinkAppend = !empty($thumbLinkAppend) ? ' '.$thumbLinkAppend : ''; // to append anything to the image within the link

if (!empty($galleryThumb['GalleryThumb']['filename'])) {
	
    $imagePath = $galleryThumb['GalleryThumb']['dir'].'thumb/'.$thumbSize.'/'.$galleryThumb['GalleryThumb']['filename'];
    $image = $this->Html->image($imagePath, $thumbImageOptions,	array(
    	'conversion' => $galleryThumb['GallerySettings']['conversionType'],
		'quality' => 75,
		'alt' => 'thumbnail',
		));	
} else {
	$imagePath = '/img/noImage.jpg';
    $image = $this->Html->image($imagePath,	$thumbImageOptions);	
}

echo !empty($thumbLink) ? $this->Html->link($image . $thumbLinkAppend, $thumbLink, $thumbLinkOptions) :	$image;