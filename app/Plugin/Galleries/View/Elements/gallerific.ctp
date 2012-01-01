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
	# if its edit page we add a few actions
	$editPage = strpos($this->request->url, 'edit/') ? true : false;
	
	# put default variable setups here
	
	# additional files needed for gallery display
	echo $this->Html->css('/galleries/css/galleriffic/galleriffic-2', '', array('inline' => 0));
	echo $this->Html->script('/galleries/js/galleriffic/jquery.galleriffic', array('inline' => 0));
	echo $this->Html->script('/galleries/js/galleriffic/jquery.opacityrollover', array('inline' => 0));
	
?>

<!-- Start Advanced Gallery Html Containers --> 
	<div id="inlineGallery">
        <div id="gallery" class="gallery-content"> 
			<div id="controls" class="controls"></div> 
			<div class="slideshow-container"> 
				<div id="loading" class="loader"></div> 
				<div id="slideshow" class="slideshow">
				<?php 
				# uses large version during dynamic conversion for highest quality (performance?? unknown) : 12/31/2011 RK
				$largeImage = $gallery['GalleryImage'][0]['dir'].'thumb/large/'.$gallery['GalleryImage'][0]['filename'];
				echo $this->Html->image($largeImage,
					array(
						'width' => $gallery['Gallery']['largeImageWidth'], 
						'height' => $gallery['Gallery']['largeImageHeight'],
						),
					array(
						'conversion' => $gallery['Gallery']['conversionType'],
						'quality' => 75,
						)); ?></div> 
			</div> 
			<div id="caption" class="caption-container"></div> 
		</div> 
		<div id="thumbs" class="navigation"> 
			<ul class="thumbs noscript">
			<?php
            foreach ($gallery['GalleryImage'] as $slide) {
				$largeImage = $slide['dir'].'thumb/large/'.$slide['filename']; ?>
				<li>
   					<?php 
					# uses large version during dynamic conversion for highest quality (performance?? unknown) : 12/31/2011 RK
					$largeImage = $slide['dir'].'thumb/large/'.$slide['filename'];
					$image = $this->Html->image($largeImage, 
						array(
							'width' => $gallery['Gallery']['smallImageWidth'], 
							'height' => $gallery['Gallery']['smallImageWidth'],
							'alt' => $slide['caption'],
							), 
						array(
							'conversion' => $gallery['Gallery']['conversionType'],
							'quality' => 75,
							));		
					echo $this->Html->link($image,
						'/'.$largeImage, 
						array(
							'escape' => false,
							'id' => 'galleryImage' . $gallery['GalleryImage'][0]['id'],
							'class' => 'thumb',
							'name' => 'leaf',
							'title' => $slide['caption'],
							)); 
					if (!empty($editPage)) { ?>
	               		<div class="action galleryMakeThumb"><?php echo $this->Html->link(__('Make Thumb', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'make_thumb', $gallery['Gallery']['id'], $slide['id']), array('class' => 'action', 'title' => 'Make this image the thumbnail for this gallery.')); ?></div>
						<div class="action galleryEdit"><?php echo $this->Html->link(__('Edit', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'edit', $slide['id']), array('class' => 'action')); ?></div>
						<div class="action galleryDelete"><?php echo $this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slide['id']), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slide['id'])); ?></div>
                	<?php
					} ?>
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
		
	});'); 
} // end of gallery display
?>