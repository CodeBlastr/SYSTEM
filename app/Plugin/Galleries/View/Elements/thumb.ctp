<?php
/**
 * Gallery Thumb Element
 *
 * Displays the thumb nail image for a gallery.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.galleries.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
if (!empty($model) && !empty($foreignKey)) {
	$galleryThumb = $this->requestAction("/galleries/galleries/thumb/{$model}/{$foreignKey}");
} else {
	#echo __('Gallery model and foreignKey were not provided (Galleries/View/Elements/thumb.ctp)');
}
# set up the config vars
$thumbLink = !empty($thumbLink) ? $thumbLink : (!empty($galleryThumb) ? array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'view', 'Gallery', $galleryThumb['Gallery']['id']) : null);
$thumbSize = !empty($thumbSize) ? $thumbSize : 'small';
# get width from settings table
$indexWidth = !empty($galleryThumb['GallerySettings']['indexImageWidth']) ? $galleryThumb['GallerySettings']['indexImageWidth'] : $galleryThumb['GallerySettings'][$thumbSize.'ImageWidth'];
$indexHeight = !empty($galleryThumb['GallerySettings']['indexImageHeight']) ? $galleryThumb['GallerySettings']['indexImageHeight'] : $galleryThumb['GallerySettings'][$thumbSize.'ImageHeight'];
# if the width was defined in the element call
$thumbWidth = !empty($thumbWidth) ? array('width' => $thumbWidth) : array('width' => $indexWidth);
$thumbHeight = !empty($thumbHeight) ? array('height' => $thumbHeight) : array('height' => $indexHeight);
$thumbAlt = !empty($thumbAlt) ? array('alt' => $thumbAlt) : array('alt' => $galleryThumb['GalleryThumb']['filename']);
$thumbClass = !empty($thumbClass) ? array('class' => $thumbClass) : array('class' => 'gallery-thumb');
$thumbId = !empty($thumbId) ? array('id' => $thumbId) : array('id' => 'gallery'.$galleryThumb['Gallery']['id']);
$thumbImageOptions = array_merge($thumbWidth, $thumbHeight, $thumbAlt, $thumbClass, $thumbId);

$thumbDiv = isset($thumbDiv) ? ($thumbDiv==true ? true : false) : true; //added to skip the display of div on demand (true/false)
$thumbLinkOptions = !empty($thumbLinkOptions) ? array_merge($thumbClass, $thumbId, $thumbLinkOptions, array('escape' => false)) : array('escape' => false);
$thumbLinkAppend = !empty($thumbLinkAppend) ? ' '.$thumbLinkAppend : ''; //to append anything to the image within the link

if (!empty($galleryThumb)) {
	if($thumbDiv)	{ echo "<div {$thumbClass} {$thumbId}>";  } 
		$imagePath = $galleryThumb['GalleryThumb']['dir'].'thumb/'.$thumbSize.'/'.$galleryThumb['GalleryThumb']['filename'];
        $image = $this->Html->image($imagePath, $thumbImageOptions,
			array(
				'conversion' => $galleryThumb['GallerySettings']['conversionType'],
				'quality' => 75,
				));	
		echo $this->Html->link($image . $thumbLinkAppend, $thumbLink, $thumbLinkOptions); 
		
	if($thumbDiv) { echo "</div>"; } 
} else {
	if($thumbDiv) {  echo "<div {$thumbClass} {$thumbId}>"; }
		$imagePath = '/img/noImage.jpg';
        $image = $this->Html->image($imagePath,
			array(
				'width' => $thumbWidth, 
				'height' => $thumbHeight,
				'alt' => 'no image',
				));	
		echo !empty($thumbLink) ? 
			$this->Html->link($image . $thumbLinkAppend, $thumbLink, $thumbLinkOptions) :
			$image;
	if($thumbDiv) { echo '</div>'; } 
}