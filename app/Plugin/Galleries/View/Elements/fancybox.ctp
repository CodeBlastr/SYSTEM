<?php
# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_GALLERIES_FANCYBOX_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_GALLERIES_FANCYBOX_'.$instance)));
} else if (defined('__ELEMENT_GALLERIES_FANCYBOX')) {
	extract(unserialize(__ELEMENT_GALLERIES_FANCYBOX));
}

if (!empty($gallery['GalleryImage'][0])) {
	# put default variable setups here
	$overlayShow = !empty($overlayShow) ? $overlayShow : 'true'; // true, false (string)
	$transitionIn = !empty($transitionIn) ? $transitionIn : 'elastic'; // none, elastic
	$transitionOut = !empty($transitionOut) ? $transitionOut : 'elastic'; // none, elastic
	$opacity = !empty($opacity) ? $opacity : 'true'; // true, false (string)
	$overlayOpacity = !empty($overlayOpacity) ? $overlayOpacity : '.7'; // 0-1 (decimal))
	$titlePosition = !empty($titlePosition) ? $titlePosition : 'over'; // outside, inside, over
	$fancyType = !empty($fancyType) ? $fancyType : 'image'; // image, iframe
	$fancyPadding =  !empty($fancyPadding) ? $fancyPadding : '10'; // 0+ (int)
	$changeFade = !empty($changeFade) ? $changeFade : '300'; // 0+ (int)
	# $width  # used for iframe type only (i think)
	# $height # used for iframe type only (i think)
	# $autoScale  # user for iframe type only (i think)
	$wishList = !empty($wishList) ? true : false;
	$favoriteList = !empty($favoriteList) ? true : false;
	$watchList = !empty($watchList) ? true : false;
	$zoomType = 'colorbox';
	
	# additional files needed for gallery display
	echo $this->Html->script('/galleries/js/fancybox/jquery.mousewheel-3.0.4.pack'); 
	echo $this->Html->script('/galleries/js/fancybox/jquery.fancybox-1.3.4.pack');
	echo $this->Html->css('/galleries/css/fancybox/jquery.fancybox-1.3.4');	?>

    <div class="fancyboxGallery">
      <div id="mediumImage"> 
        <?php
        # uses large version during dynamic conversion for highest quality (performance?? unknown) : 12/31/2011 RK
        $largeImage = $gallery['GalleryImage'][0]['dir'].'thumb/large/'.$gallery['GalleryImage'][0]['filename'];
        $image = $this->Html->image($largeImage,
            array(
                'width' => $gallery['GallerySettings']['mediumImageWidth'], 
                'height' => $gallery['GallerySettings']['mediumImageHeight'],
                'alt' => $gallery['GalleryImage'][0]['caption'],
                ),
            array(
                'conversion' => $gallery['GallerySettings']['conversionType'],
                'quality' => 75,
                ));	
        echo $this->Html->link($image,
            '/'.$largeImage, 
            array(
                'escape' => false,
                'id' => 'galleryImage' . $gallery['GalleryImage'][0]['id'],
                'class' => 'fancybox galleryImage',
                'title' => $gallery['GalleryImage'][0]['caption'],
                ));  ?>  
      </div>
      <div id="description"><?php $gallery['GalleryImage'][0]['description']; ?></div>
      <ul class="thumbs">
        <?php
        $slides = '';
        foreach ($gallery['GalleryImage'] as $slide) {
            $slides .= '"'.$slide['dir'].'thumb/large/'.$slide['filename'].'",'; ?>
            <li class="thumb" id="thumb<?php echo $slide['id']; ?>">
              <ul>
                <li class="thumbImg">
               	<?php
           		# uses large version during dynamic conversion for highest quality (performance?? unknown) : 12/31/2011 RK
	            $largeImage = $slide['dir'].'thumb/large/'.$slide['filename'];
	            $image = $this->Html->image($largeImage,
	                array(
	                    'width' => $gallery['GallerySettings']['smallImageWidth'], 
	                    'height' => $gallery['GallerySettings']['smallImageHeight'],
	                    'alt' => $slide['alt'],
	                    ),
	                array(
	                    'conversion' => $gallery['GallerySettings']['conversionType'],
	                    'quality' => 75,
	                    ));	
	            echo $this->Html->link($image,
	                '/'.$largeImage, 
	                array(
	                    'escape' => false,
	                    'id' => 'galleryImage' . $slide['id'],
	                    'class' => 'jqzoom2 zoomable galleryImage',
	                    'title' => $slide['caption'],
	                    )); 
				echo $this->Element('actions', array('galleryId' => $gallery['Gallery']['id'], 'slideId' => $slide['id']), array('plugin' => 'galleries')); ?>
                </li>
                <li class="thumbMedium">
               	<?php
           		# uses large version during dynamic conversion for highest quality (performance?? unknown) : 12/31/2011 RK
	            $largeImage = $slide['dir'].'thumb/large/'.$slide['filename'];
	            $image = $this->Html->image($largeImage,
	                array(
	                    'width' => $gallery['GallerySettings']['mediumImageWidth'], 
	                    'height' => $gallery['GallerySettings']['mediumImageHeight'],
	                    'alt' => $slide['alt'],
	                    ),
	                array(
	                    'conversion' => $gallery['GallerySettings']['conversionType'],
	                    'quality' => 75,
	                    ));	
	            echo $this->Html->link($image,
	                '/'.$largeImage, 
	                array(
	                    'escape' => false,
	                    'id' => 'galleryImage' . $slide['id'],
	                    'class' => 'fancybox',
	                    'title' => $slide['caption'],
						'rel' => 'image_group',
	                    )); ?>
                </li>
                <li class="description"> <?php echo $slide['description']; ?>
                  <?php 
                     if (isset($wishList) && $wishList == true) {
                        echo $this->Favorites->toggleFavorite('wish', $slide['id']);
                     }
                     if (isset($favoriteList) && $favoriteList == true) {
                        echo $this->Favorites->toggleFavorite('favorite', $slide['id']);
                     }  
                     if (isset($watchList) && $watchList == true) {
                        echo $this->Favorites->toggleFavorite('watch', $slide['id']);
                     } ?>
                </li>
              </ul>
            </li>
        <?php 
        } // end images loop ?>
      </ul>
    </div>
	<?php
	#slide options and javascript output
	echo $this->Html->scriptBlock('	$(document).ready(function(){
		var options = {
			"overlayShow"		: '.$overlayShow.',
			"padding"			: '.$fancyPadding.',
			"transitionIn"		: "'.$transitionIn.'",
			"transitionOut"		: "'.$transitionOut.'",
			"titlePosition"		: "'.$titlePosition.'",
			"type"              : "'.$fancyType.'",
			"overlayOpacity"	: '.$overlayOpacity.',
			"changeFade"        : '.$changeFade.',
			"titleFormat"		: function(title, currentArray, currentIndex, currentOpts) {
				return "<span id=\"fancybox-title-over\">Image " + (currentIndex + 1) + " / " + currentArray.length + (title.length ? " &nbsp; " + title : "") + "</span>";
			}
		}
		// handle the changing of thumbnails
		$("ul.thumbs li.thumb ul li.thumbImg a.jqzoom2").click(function () {
			var htmlStr = $(this).parent().parent().children("li.thumbMedium").html();
			var newDescHtml = $(this).parent().parent().children("li.description").html();
			$("#mediumImage").html(htmlStr);
			$(".fancybox").fancybox(options);
			$("#description").html(newDescHtml);
			return false;
		});
		$(".thumbMedium").hide();
		$(".description").hide();
		var descHtml = $("ul.thumbs li:first-child ul li.description").html();
		$("#description").html(descHtml);
		$("a[rel=image_group]").fancybox(options);
		$("ul.thumbs li:first-child.thumb ul li.thumbImg a.jqzoom2").trigger("click");
		});', array('inline' => 0)); ;	
} // end of gallery image check ?>