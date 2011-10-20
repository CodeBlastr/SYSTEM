<?php
/**
 * Gallerific Gallery Element
 *
 * Used to display the gallery html, when the gallery type is "gallerific".
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
 * @subpackage    zuha.app.plugins.galleries.views
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Needs some major work on the presentation, so that it is extendable across multiple uses and multiple sites.  Right now you have to do a ton of css work to get it to look right, and it should not be so hard.  If the css was flexible for both width and height, and if you didn't have to specify specific widths and heights, you could just define the container div styles and it would be a much better way of handling it.
 */

if(!empty($gallery['Gallery']['GalleryImage'])) {
	$gallery = $gallery['Gallery'];
}
# out put the css needed
echo $this->Html->css('/galleries/css/galleriffic/galleriffic-2', '', array('inline' => 0));
# out put the javascript needed 
echo $this->Html->script('/galleries/js/galleriffic/jquery.galleriffic', array('inline' => 0));
echo $this->Html->script('/galleries/js/galleriffic/jquery.opacityrollover', array('inline' => 0));

	if (strpos($this->request->url, 'edit/')) {
		# this is an edit page we should show a delete button
		$editPage = true;
	}		
		# the gallery wrapper
?>

<!-- Start Advanced Gallery Html Containers --> 
	<div id="inlineGallery">
        <div id="gallery" class="gallery-content"> 
			<div id="controls" class="controls"></div> 
			<div class="slideshow-container"> 
				<div id="loading" class="loader"></div> 
				<div id="slideshow" class="slideshow"><img src="<?php echo $value['links'][0]['fullUrl']; ?>" /></div> 
			</div> 
			<div id="caption" class="caption-container"></div> 
		</div> 
		<div id="thumbs" class="navigation"> 
			<ul class="thumbs noscript">
	<?php if (!empty($value['links'])) { foreach ($value['links'] as $slide) { ?>
				<li> 
					<a class="thumb" name="leaf" href="<?php echo $slide['fullUrl']; ?>" title="<?php echo $slide['title']; ?>"> 
					<img src="<?php echo $slide['thumbUrl']; ?>" alt="<?php echo $slide['title']; ?>" width="<?php echo $slide['thumbWidth']; ?>" height="<?php echo $slide['thumbHeight']; ?>" /> 
					</a>
				<?php if (isset($editPage) && $editPage == true) { ?>
	                <?php echo $this->Html->link(__('Make Thumb', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'make_thumb', $gallery['Gallery']['id'], $slide['thumbId']), array('class' => 'action', 'title' => 'Make this image the thumbnail for this gallery.')); ?>
					<?php echo $this->Html->link(__('Edit', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'edit', $slide['thumbId']), array('class' => 'action')); ?>
					<div class="action galleryDelete"><?php echo $this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slide['thumbId']), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slide['thumbId'])); ?></div>
                <?php } ?>
					<div class="caption">
						<div class="image-title"><?php echo $slide['description']; ?></div> 
							<!--div class="image-desc"></div--> 
						</div> 
					</li>
       <?php } } ?>
       		</ul> 
		</div><!-- End #thumbs -->
	</div><!--End #inlineGallery -->
	<div style="clear: both;"></div>
				
<?php echo $this->Html->scriptBlock('
	jQuery(document).ready(function($) {
		// We only want these styles applied when javascript is enabled
		$("div.gallery-content").css("display", "block");
		$("div.slideshow-container").css("height", $("#slideshow img").height());
		$("div.slideshow-container").css("width", $("#slideshow img").width());
		$("#slideshow img").hide();
		// Initially set opacity on thumbs and add
		// additional styling for hover effect on thumbs
		var onMouseOutOpacity = 0.67;
		$("#thumbs ul.thumbs li").opacityrollover({
			mouseOutOpacity:   onMouseOutOpacity,
			mouseOverOpacity:  1.0,
			fadeSpeed:         "fast",
			exemptionSelector: ".selected"
		});
		
		// Initialize Advanced Galleriffic Gallery
		var gallery = $("#thumbs").galleriffic({
			delay:                     2500,
			numThumbs:                 15,
			preloadAhead:              10,
			enableTopPager:            true,
			enableBottomPager:         true,
			maxPagesToShow:            7,
			imageContainerSel:         "#slideshow",
			controlsContainerSel:      "#controls",
			captionContainerSel:       "#caption",
			loadingContainerSel:       "#loading",
			renderSSControls:          true,
			renderNavControls:         true,
			playLinkText:              "Play Slideshow",
			pauseLinkText:             "Pause Slideshow",
			prevLinkText:              "&lsaquo; Previous Photo",
			nextLinkText:              "Next Photo &rsaquo;",
			nextPageLinkText:          "Next &rsaquo;",
			prevPageLinkText:          "&lsaquo; Prev",
			enableHistory:             false,
			autoStart:                 false,
			syncTransitions:           true,
			defaultTransitionDuration: 2000,
			onSlideChange:             function(prevIndex, nextIndex) {
				// "this" refers to the gallery, which is an extension of $("#thumbs")
				this.find("ul.thumbs").children()
					.eq(prevIndex).fadeTo("fast", onMouseOutOpacity).end()
					.eq(nextIndex).fadeTo("fast", 1.0);
			},
			onPageTransitionOut:       function(callback) {
				this.fadeTo("fast", 0.0, callback);
			},
			onPageTransitionIn:        function() {
				this.fadeTo("fast", 1.0);
			}
		});
		
	});', array('inline' => 0)); 
?>