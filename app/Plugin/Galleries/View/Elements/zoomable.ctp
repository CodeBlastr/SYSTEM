<?php
# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_GALLERIES_ZOOMABLE_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_GALLERIES_ZOOMABLE_'.$instance)));
} else if (defined('__ELEMENT_GALLERIES_ZOOMABLE')) {
	extract(unserialize(__ELEMENT_GALLERIES_ZOOMABLE));
}

# make a request action to pull the gallery data
$gallery = $this->requestAction('/galleries/galleries/view/'.$id); 

# setup up your configurable options with defaults
$zoomWidth = !empty($zoomWidth) ? $zoomWidth : 350;
$zoomHeight = !empty($zoomHeight) ? $zoomHeight : 350;
$zoomType = !empty($zoomType) ? $zoomType : 'reverse'; // standard, reverse, colorbox
$zoomTitle = !empty($zoomTitle) ? $zoomTitle : 'true'; // true, false (string)
$zoomLens = !empty($zoomLens) ? $zoomLens : 'true'; // true, false (string)
$zoomPosition = !empty($zoomPosition) ? $zoomPosition : 'right'; // bottom, right (string)
$zoomyOffset = !empty($zoomyOffset) ? $zoomyOffset : 'false'; // integer (positve or negative), or false (string)
$zoomxOffset = !empty($zoomxOffset) ? $zoomxOffset : 'false'; // integer (positve or negative), or false (string)
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
	echo $this->Html->script('/galleries/js/zoomable/jquery.jqzoom1.0.1');
	# out put the css needed
	echo $this->Html->css('/galleries/css/zoomable/jqzoom');
	echo $this->Html->scriptBlock('
		$(document).ready(function(){
			$(function() {
				var options2 =
				{
					zoomWidth: '.$zoomWidth.',
					zoomHeight: '.$zoomHeight.',
					zoomType: \''.$zoomType.'\',
					title: '.$zoomTitle.',
					lens: '.$zoomLens.',
					position : \''.$zoomPosition.'\',
					yOffset : '.$zoomyOffset.',
					xOffset : '.$zoomxOffset.',
				}
				$("#mediumImage .jqzoom2").jqzoom(options2);   //da sistemare top/bottom
				$(".thumb .thumbImg a").click(function () {
					var htmlStr = $(this).parent().parent().children("li.thumbMedium").html();
					var newDescHtml = $(this).parent().parent().children("li.description").html();
					$("#mediumImage").html(htmlStr);
					$("#mediumImage .jqzoom2").jqzoom(options2);
					$("#description").html(newDescHtml);
					return false;
				});
				$(".thumbMedium").hide();
				$(".description").hide();
				var descHtml = $("ul.thumbs li:first-child ul li.description").html();
				$("#description").html(descHtml);
			});
		});'); ;
		
	if (strpos($this->request->url, 'edit/')) {
		# this is an edit page we should show a delete button
		$editPage = true;
	}
?>
<div class="zoomableGallery">
	<div id="mediumImage">
        <?php 
		$mediumImage = $gallery['GalleryImage'][0]['dir'].'thumb/medium/'.$gallery['GalleryImage'][0]['filename'];
		$image = $this->Html->image($mediumImage, 
			array(
				'width' => $gallery['Gallery']['mediumImageWidth'], 
				'height' => $gallery['Gallery']['mediumImageWidth'],
				'alt' => $gallery['GalleryImage'][0]['caption'],
				), 
			array(
				'conversion' => $gallery['Gallery']['conversionType'],
				'quality' => 75,
				));		
		echo $this->Html->link($image,
			'/'.$gallery['GalleryImage'][0]['dir'].'thumb/large/'.$gallery['GalleryImage'][0]['filename'], 
			array(
				'escape' => false,
				'id' => 'galleryImage' . $gallery['GalleryImage'][0]['id'],
				'class' => 'jqzoom2 zoomable galleryImage',
				'title' => $gallery['GalleryImage'][0]['caption'],
				)); ?>
    </div>
    <div id="description"></div>
    <ul class="thumbs">
<?php
	foreach ($gallery['GalleryImage'] as $slide) :
?>
	<li class="thumb" id="thumb<?php echo $slide['id']; ?>">
    	<ul>
        	<li class="thumbImg">
            	<?php
                echo $this->Html->image($slide['dir'].'thumb/small/'.$slide['filename'],
					array(
						'width' => $gallery['Gallery']['smallImageWidth'], 
						'height' => $gallery['Gallery']['smallImageHeight'],
						'url' => $slide['dir'].'thumb/medium/'.$slide['filename'],
						),
					array(
						'conversion' => $gallery['Gallery']['conversionType'],
						'quality' => 75,
						)); ?>
            </li>
            <li class="thumbMedium">
            	<?php
                $image = $this->Html->image($slide['dir'].'thumb/medium/'.$slide['filename'],
					array(
						'width' => $gallery['Gallery']['mediumImageWidth'], 
						'height' => $gallery['Gallery']['mediumImageHeight'],
						),
					array(
						'conversion' => $gallery['Gallery']['conversionType'],
						'quality' => 75,
						));	
				echo $this->Html->link($image,
					'/'.$slide['dir'].'thumb/large/'.$slide['filename'], 
					array(
						'escape' => false,
						'id' => 'galleryImage' . $gallery['GalleryImage'][0]['id'],
						'class' => 'jqzoom2 zoomable galleryImage',
						'title' => $gallery['GalleryImage'][0]['caption'],
						)); ?>
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
endif; // end of gallery display
?> 