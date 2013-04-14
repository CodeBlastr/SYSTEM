<?php
# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_GALLERIES_GALLERIFIC_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_GALLERIES_GALLERIFIC_'.$instance)));
} else if (defined('__ELEMENT_GALLERIES_GALLERIFIC')) {
	extract(unserialize(__ELEMENT_GALLERIES_GALLERIFIC));
}

# out put the css needed
if (!empty($gallery['GalleryImage'][0])) {
	# put default variable setups here
	
	# additional files needed for gallery display
	echo $this->Html->css('/galleries/css/galleriffic/galleriffic-2', '', array('inline' => false, 'once'=>true));
	echo $this->Html->script('/galleries/js/galleriffic/jquery.galleriffic', array('inline' => false, 'once'=>true));
	echo $this->Html->script('/galleries/js/galleriffic/jquery.opacityrollover', array('inline' => false, 'once'=>true)); ?>

    <div id="inlineGallery">
      <div id="gallery" class="gallery-content">
        <div id="controls" class="controls"></div>
        <div class="slideshow-container">
          <div id="loading" class="loader"></div>
          <div id="slideshow" class="slideshow">
            <?php 
            // uses large version during dynamic conversion for highest quality (performance?? unknown)
            $largeImage = $gallery['GalleryImage'][0]['dir'].'thumb/large/'.$gallery['GalleryImage'][0]['filename'];
            echo $this->Html->image($largeImage,
                array(
                    'width' => $gallery['GallerySettings']['largeImageWidth'], 
                    'height' => $gallery['GallerySettings']['largeImageHeight'],
                    //'alt' => $gallery['GalleryImage'][0]['alt'],
                    'style' => 'display: block;'
                    ),
                array(
                    'conversion' => $gallery['GallerySettings']['conversionType'],
                    'quality' => 80,
                    )); ?>
          </div>
        </div>
        <div id="caption" class="caption-container"></div>
      </div>
      <div id="thumbs" class="navigation">
        <ul class="thumbs noscript">
            <?php
            foreach ($gallery['GalleryImage'] as $slide) { ?>
	          	<li>
	            <?php 
	            // uses large version during dynamic conversion for highest quality (performance?? unknown) : 12/31/2011 RK
	            $largeImage = $slide['dir'].'thumb/large/'.$slide['filename'];
	            $image = $this->Html->image($largeImage, 
	            	array(
	                	'width' => $gallery['GallerySettings']['smallImageWidth'], 
	                    'height' => $gallery['GallerySettings']['smallImageHeight'],
	                    'alt' => $slide['alt'],
	                    ), 
	                array(
	                    'conversion' => $gallery['GallerySettings']['conversionType'],
	                    'quality' => 80,
	                    ));	
				// make the large image for real now, because we link to it with the small image
				$largeImage = $this->Html->image($largeImage, 
	            	array(
	                	'width' => $gallery['GallerySettings']['largeImageWidth'], 
	                    'height' => $gallery['GallerySettings']['largeImageHeight'],
	                    'alt' => $slide['alt'],
	                    ), 
	                array(
	                    'conversion' => $gallery['GallerySettings']['conversionType'],
	                    'quality' => 80,
	                    ));	
				if (!empty($largeImage)) {
					$doc = new DOMDocument();
					$doc->loadHTML($largeImage);
					$xml = simplexml_import_dom($doc);
					$largeImgSrc = $xml->xpath('//img/@src');
				}
//				debug($largeImage);
//				debug($largeImgSrc[0]);
	            echo $this->Html->link($image,
	            	'/'.$largeImgSrc[0], 
	                array(
	                	'escape' => false,
	                    'id' => 'galleryImage' . $gallery['GalleryImage'][0]['id'],
	                    'class' => 'thumb',
	                    'name' => 'leaf',
	                    'title' => $slide['caption'],
	                    )); 
					
	            echo $this->Element('actions', array('galleryId' => $gallery['Gallery']['id'], 'slideId' => $slide['id']), array('plugin' => 'galleries')); ?>
	            <div class="caption">
	            	<div class="image-title"><?php echo $slide['description']; ?></div>
	            </div>
	          	</li>
          	<?php
            } // end images loop ?>
        </ul>
      </div>
    </div>
	<?php
	echo $this->Html->scriptBlock('jQuery(document).ready(function($) {
		// Initially set opacity on thumbs and addadditional styling for hover effect on thumbs
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
			
			// We only want these styles applied when javascript is enabled
			$("div.gallery-content").css("display", "block");
			$("div.slideshow-container").css("height", $("#slideshow img").attr("height"));
			$("div.slideshow-container").css("width", $("#slideshow img").width());
			//$("#slideshow img").hide();
		});'); 
} // end gallery image check ?>
