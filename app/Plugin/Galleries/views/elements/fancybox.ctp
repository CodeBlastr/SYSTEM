<?php
// http://fancybox.net/blog
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_GALLERIES_FANCYBOX_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_GALLERIES_FANCYBOX_'.$instance)));
} else if (defined('__ELEMENT_GALLERIES_FANCYBOX')) {
	extract(unserialize(__ELEMENT_GALLERIES_FANCYBOX));
}
# make a request action to pull the gallery data
$gallery = $this->requestAction('/galleries/galleries/view/'.$id); 

# setup up your configurable options with defaults
$overlayShow = !empty($overlayShow) ? $overlayShow : 'true'; // true, false (string)
$transitionIn = !empty($transitionIn) ? $transitionIn : 'elastic'; // none, elastic
$transitionOut = !empty($transitionOut) ? $transitionOut : 'elastic'; // none, elastic
$opacity = !empty($opacity) ? $opacity : 'true'; // true, false (string)
$overlayOpacity = !empty($overlayOpacity) ? $overlayOpacity : '.7'; // 0-1 (decimal))
$titlePosition = !empty($titlePosition) ? $titlePosition : 'over'; // outside, inside, over
$fancyType = !empty($fancyType) ? $fancyType : 'image'; // image, iframe
$fancyPadding =  !empty($fancyPadding) ? $fancyPadding : '10'; // 0+ (int)
$changeFade = !empty($changeFade) ? $changeFade : '300'; // 0+ (int)
// $width  # used for iframe type only (i think)
// $height # used for iframe type only (i think)
// $autoScale  # user for iframe type only (i think)

$wishList = !empty($wishList) ? true : false;
$favoriteList = !empty($favoriteList) ? true : false;
$watchList = !empty($watchList) ? true : false;
# fix up anything that might be contained differently
if(!empty($gallery['Gallery']['GalleryImage'])) {
	$gallery['GalleryImage'] = $gallery['Gallery']['GalleryImage'];
}
$zoomType = 'colorbox';

if (!empty($gallery['GalleryImage'][0])) :
	# more config options : http://www.mind-projects.it/projects/jqzoom/
	# out put the javascript needed 
	echo $this->Html->script('/galleries/js/fancybox/jquery.mousewheel-3.0.4.pack'); 
	echo $this->Html->script('/galleries/js/fancybox/jquery.fancybox-1.3.4.pack');	
	# out put the css needed
	echo $this->Html->css('/galleries/css/fancybox/jquery.fancybox-1.3.4');	
		
	if (strpos($this->request->url, 'edit/')) {
		# this is an edit page we should show a delete button
		$editPage = true;
	}
?>
<div class="fancyboxGallery">
	<div id="mediumImage">
	    <a id="galleryImage<?php echo $gallery['GalleryImage'][0]['id']; ?>" class="fancybox galleryImage" title="<?php echo $gallery['GalleryImage'][0]['caption']; ?>" href="<?php echo $gallery['GalleryImage'][0]['dir'].'thumb/large/'.$gallery['GalleryImage'][0]['filename']; ?>"><img src="<?php echo $gallery['GalleryImage'][0]['dir'].'thumb/medium/'.$gallery['GalleryImage'][0]['filename']; ?>" alt="<?php echo $gallery['GalleryImage'][0]['caption']; ?>"></a>
    </div>
    <div id="description"></div>
    <ul class="thumbs">
<?php
	$slides = '';
	foreach ($gallery['GalleryImage'] as $slide) :
		$slides .= '"'.$slide['dir'].'thumb/large/'.$slide['filename'].'",';
?>
	<li class="thumb" id="thumb<?php echo $slide['id']; ?>">
    	<ul>
        	<li class="thumbImg">
            	<!-- medium image -->
		    	<a href="<?php echo $slide['dir'].'thumb/medium/'.$slide['filename']; ?>" title="<?php echo $slide['caption']; ?>">
               	<!-- smallest image -->
                <img src="<?php echo $slide['dir'].'thumb/small/'.$slide['filename']; ?>" alt="<?php echo $slide['alt']; ?>">
                </a>
            </li>
            <li class="thumbMedium">
            	<!-- largest image --> 
            	<a href="<?php echo $slide['dir'].'thumb/large/'.$slide['filename']; ?>" rel="image_group"  class="fancybox" title="<?php echo $slide['caption']; ?>"> 
                <!-- medium image -->
                <img src="<?php echo $slide['dir'].'thumb/medium/'.$slide['filename']; ?>" alt="<?php echo $slide['alt']; ?>"> 
                </a>
            </li>
            <li class="description">
            <?php echo $slide['description']; ?>
	    	<?php 
			 if (isset($wishList) && $wishList == true) {
			 	echo $this->Favorites->toggleFavorite('wish', $slide['id']);
			 }
			 if (isset($favoriteList) && $favoriteList == true) {
				echo $this->Favorites->toggleFavorite('favorite', $slide['id']);
			 }  
			 if (isset($watchList) && $watchList == true) {
				echo $this->Favorites->toggleFavorite('watch', $slide['id']);
			 }               
	    	 if (isset($editPage) && $editPage == true) { ?>
				<?php echo $this->Html->link(__('Make Thumb', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'make_thumb', $gallery['Gallery']['id'], $slide['id']), array('class' => 'action', 'title' => 'Make this image the thumbnail for this gallery.')); ?>
				<?php echo $this->Html->link(__('Edit', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'edit', $slide['id']), array('class' => 'action')); ?>
				<?php echo $this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slide['id']), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slide['id'])); ?>
			<?php } ?>
            </li>       
         </ul>
	</li>
<?php 
	endforeach; // end of gallery images
?>
	</ul> 
</div>
<?php
	#slide options and javascript output
	echo $this->Html->scriptBlock('
		$(document).ready(function(){
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
			$(".thumb ul li.thumbImg a").click(function () {
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
			$("li.thumb ul li.thumbImg a").trigger("click");
		});', array('inline' => 0)); ;
	
endif; // end of gallery display
?> 