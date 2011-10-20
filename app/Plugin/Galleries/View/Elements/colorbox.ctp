<?php

$gallery = $this->requestAction('/galleries/galleries/view/'.$id);

if(!empty($gallery['Gallery']['GalleryImage'])) {
	$gallery['GalleryImage'] = $gallery['Gallery']['GalleryImage'];
}

if (!empty($gallery['GalleryImage'][0])) { 
	# more examples : http://colorpowered.com/colorbox/core/example2/index.html
	# out put the css needed
	echo $this->Html->css('/galleries/css/colorbox/colorbox', '', array('inline' => 0));
	# out put the javascript needed 
	echo $this->Html->script('/galleries/js/colorbox/jquery.colorbox-min', array('inline' => 0));
	# small script for showing the boxes			
	echo $this->Html->scriptBlock('
		$(document).ready(function(){
			$("a[rel=\'example4\']").colorbox({
				slideshow:true,
			});
		});', array('inline' => 0)); 
	if (strpos($this->request->url, 'edit/')) {
		# this is an edit page we should show a delete button
		$editPage = true;
	}
	
	foreach ($gallery['GalleryImage'] as $slide) {
?>
	    <div id="galleryImage<?php echo $slide['id']; ?>" class="colorBoxGallerImage colorbox galleryImage">
		<a href="<?php echo $slide['dir'].'thumb/large/'.$slide['filename']; ?>" rel="example4" title="<?php echo $slide['caption']; ?>"><img src="<?php echo $slide['dir'].'thumb/small/'.$slide['filename']; ?>" alt="<?php echo $slide['filename']; ?>"></a>
        
    	<?php if (isset($editPage) && $editPage == true) { ?>
	        <?php echo $this->Html->link(__('Make Thumb', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'make_thumb', $gallery['Gallery']['id'], $slide['id']), array('class' => 'action', 'title' => 'Make this image the thumbnail for this gallery.')); ?>
			<?php echo $this->Html->link(__('Edit', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'edit', $slide['id']), array('class' => 'action')); ?>
			<?php echo $this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slide['id']), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slide['id'])); ?>
		<?php } ?>
		</div>
<?php 
	}
}
?>