<?php

class GalleryHelper extends AppHelper {
    
	var $value = '';
	var $helpers = array('Html');
    
    function displayGallery($value) {
		if (!empty($value)) {
			if ($value['type'] == 'Overlay Slideshow') {
				return $this->__overlaySlideshow($value);				
			} if ($value['type'] == 'Inline Gallery') {
				return $this->__inlineGallery($value);				
			} else {
				echo 'invalid photogallery type';
			}
		} else {
			return 'invalid values';
		}
    }
	
	
	
	function __overlaySlideshow($value) {
		if (strpos($this->params['url']['url'], 'edit/')) {
			# this is an edit page we should show a delete button
			$editPage = true;
		}
		$gallery = '';
		if (!empty($value['links'])) { foreach ($value['links'] as $slide) {
			$gallery .= '<p>';
			$gallery .= '<a href="'.$slide['fullUrl'].'" rel="example4" title="'.$slide['title'].'"><img src="'.$slide['thumbUrl'].'" alt="'.$slide['thumbAlt'].'" width="'.$slide['thumbWidth'].'" height="'.$slide['thumbHeight'].'"></a>';
			if (isset($editPage) && $editPage == true) {
				$gallery .= $this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slide['thumbId']), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slide['thumbId']));; 				
			}
			$gallery .= '</p>'; 
		}
			
		if (!empty($gallery)) {
			# more examples : http://colorpowered.com/colorbox/core/example2/index.html
			# out put the javascript needed 
			$gallery .= $this->Html->script('galleries/colorbox/jquery.colorbox-min', array('inline' => 0));
			# out put the css needed
			$gallery .= $this->Html->css('galleries/colorbox/colorbox', '', array('inline' => 0));
			# small script for showing the boxes			
			$gallery .= $this->Html->scriptBlock('
				$(document).ready(function(){
					$("a[rel=\'example4\']").colorbox({slideshow:true});
				});', array('inline' => 0)); 
			
		    return $gallery;
		} else { 
			return false;
		}}
	}
	
	
	
	function __inlineGallery($value) {
		if (strpos($this->params['url']['url'], 'edit/')) {
			# this is an edit page we should show a delete button
			$editPage = true;
		}		
		# the gallery wrapper
		$gallery = '<!-- Start Advanced Gallery Html Containers --> 
		<div id="inlineGallery">
			<div id="gallery" class="content"> 
				<div id="controls" class="controls"></div> 
				<div class="slideshow-container"> 
					<div id="loading" class="loader"></div> 
					<div id="slideshow" class="slideshow"></div> 
				</div> 
				<div id="caption" class="caption-container"></div> 
			</div> 
			<div id="thumbs" class="navigation"> 
				<ul class="thumbs noscript"> ';
		# the gallery images
		if (!empty($value['links'])) { foreach ($value['links'] as $slide) {
			$gallery .= '<li> 
							<a class="thumb" name="leaf" href="'.$slide['fullUrl'].'" title="'.$slide['title'].'"> 
								<img src="'.$slide['thumbUrl'].'" alt="'.$slide['title'].'" width="'.$slide['thumbWidth'].'" height="'.$slide['thumbHeight'].'" /> 
							</a>';
						
			if (isset($editPage) && $editPage == true) {
				$gallery .= '<div class="action galleryDelete">'.$this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slide['thumbId']), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slide['thumbId'])).'</div>'; 				
			}
			$gallery .= '<div class="caption">
							<div class="image-title">'.$slide['title'].'</div> 
								<!--div class="image-desc"></div--> 
							</div> 
						</li> '; 
		}
		# end the gallery wrapper 
		$gallery .= '</ul> 
				</div><!-- End #thumbs -->
			</div><!--End #inlineGallery -->
			<div style="clear: both;"></div>';
				
			
		if (!empty($gallery)) {
			# more documentation at : http://www.twospy.com/galleriffic/
			# out put the css needed
			$gallery .= $this->Html->css('galleries/galleriffic/galleriffic-2', '', array('inline' => 0));
			# out put the javascript needed 
			$gallery .= $this->Html->script('galleries/galleriffic/jquery.galleriffic', array('inline' => 0));
			$gallery .= $this->Html->script('galleries/galleriffic/jquery.opacityrollover', array('inline' => 0));
			# small script for showing the boxes			
			$gallery .= $this->Html->scriptBlock('
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				$("div.navigation").css({"width" : "18%", "float" : "left"});
				$("div.content").css("display", "block");
 
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
					
		    return $gallery;
		} else { 
			return false;
		}}
	}
	
}
?>
        
        