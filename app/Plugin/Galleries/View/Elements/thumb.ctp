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
?>
<?php 
if (!empty($model) && !empty($foreignKey)) {
	$galleryThumb = $this->requestAction('/galleries/galleries/thumb/model:'.$model.'/foreignKey:'.$foreignKey);
} else {
	$galleryThumb = (!empty($id) ? $this->requestAction('/galleries/galleries/thumb/'.$id) : null);
}

// set up the config vars
$thumbLink = (!empty($thumbLink) ? $thumbLink : '/galleries/galleries/view/'.$galleryThumb['Gallery']['id']);
$thumbTitle = (!empty($thumbTitle) ? ' title ="'.$thumbTitle.'"' : ' title ="'.$galleryThumb['GalleryThumb']['filename'].'"');
$thumbSize = (!empty($thumbSize) ? $thumbSize : 'small');
$thumbWidth = (!empty($thumbWidth) ? ' width="'.$thumbWidth.'"' : null);
$thumbHeight = (!empty($thumbHeight) ? ' height="'.$thumbHeight.'"' : null);
$thumbAlt = (!empty($thumbAlt) ? ' alt="'.$thumbAlt.'"' : ' alt="'.$galleryThumb['GalleryThumb']['filename'].'"');
$thumbClass = (!empty($thumbClass) ? ' class="'.$thumbClass.'"' : ' class="gallery-thumb"');
$thumbId = (!empty($thumbId) ? ' id="'.$thumbId.'"' : ' id="gallery'.$galleryThumb['Gallery']['id'].'"');
$thumbDiv = (isset($thumbDiv) ? ($thumbDiv==true ? true : false) : true); //added to skip the display of div on demand (true/false)
$thumbLinkClass = (!empty($thumbLinkClass) ? ' class="'.$thumbLinkClass.'"' : ''); //can have  class="gallery-thumb-link-class"
$thumbLinkAppend = (!empty($thumbLinkAppend) ? ' '.$thumbLinkAppend : ''); //to append anything to the image within the link

if (!empty($galleryThumb)) {
?>
 <?php if($thumbDiv)	{ ?>
  <div <?php echo $thumbClass; echo $thumbId; ?>>
 <?php } ?>
	<a href="<?php echo $thumbLink; ?>" <?php echo $thumbTitle; ?> <?php echo $thumbLinkClass; ?>>
	<img src="<?php echo $galleryThumb['GalleryThumb']['dir']; ?>thumb/<?php echo $thumbSize; ?>/<?php echo $galleryThumb['GalleryThumb']['filename']; ?>" <?php echo $thumbAlt;  echo $thumbWidth; echo $thumbHeight; ?> /><?php echo $thumbLinkAppend; ?>
	</a>
<?php if($thumbDiv)	{ ?>
  </div>
 <?php } ?>

<?php 
} else {
	
?>	
  <?php if($thumbDiv)	{ ?>
  <div <?php echo $thumbClass; echo $thumbId; ?>>
  <?php } ?>
	<a href="<?php echo $thumbLink; ?>" <?php echo $thumbTitle; ?> <?php echo $thumbLinkClass; ?>>
	<img src="/img/noImage.jpg" <?php echo $thumbAlt;  echo $thumbWidth; echo $thumbHeight; ?> /><?php echo $thumbLinkAppend; ?>
	</a>
  <?php if($thumbDiv)	{ ?>
  </div>
  <?php } ?>
<?php
}
?>
