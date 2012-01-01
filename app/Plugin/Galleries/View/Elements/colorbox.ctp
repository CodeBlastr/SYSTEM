<?php
# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_GALLERIES_COLORBOX_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_GALLERIES_COLORBOX_'.$instance)));
} else if (defined('__ELEMENT_GALLERIES_COLORBOX')) {
	extract(unserialize(__ELEMENT_GALLERIES_COLORBOX));
}

if (!empty($gallery['GalleryImage'][0])) { 
	# if its edit page we add a few actions
	$editPage = strpos($this->request->url, 'edit/') ? true : false;
	
	# put default variable setups here
	
	# additional files needed for gallery display
	echo $this->Html->css('/galleries/css/colorbox/colorbox', '', array('inline' => 0));
	echo $this->Html->script('/galleries/js/colorbox/jquery.colorbox-min', array('inline' => 0));		
	echo $this->Html->scriptBlock('
		$(document).ready(function(){
			$("a[rel=\'example4\']").colorbox({
				slideshow:true,
			});
		});', array('inline' => 0)); 
?>
<div class="colorboxGallery">
<?php 
	foreach ($gallery['GalleryImage'] as $slide) { ?>
	    <div id="galleryImage<?php echo $slide['id']; ?>" class="colorBoxGallerImage colorbox galleryImage">
		<a href="<?php echo $slide['dir'].'thumb/large/'.$slide['filename']; ?>" rel="example4" title="<?php echo $slide['caption']; ?>"><img src="<?php echo $slide['dir'].'thumb/small/'.$slide['filename']; ?>" alt="<?php echo $slide['filename']; ?>"></a>
        
    	<?php if (isset($editPage) && $editPage == true) { ?>
	        <?php echo $this->Html->link(__('Make Thumb', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'make_thumb', $gallery['Gallery']['id'], $slide['id']), array('class' => 'action', 'title' => 'Make this image the thumbnail for this gallery.')); ?>
			<?php echo $this->Html->link(__('Edit', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'edit', $slide['id']), array('class' => 'action')); ?>
			<?php echo $this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slide['id']), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slide['id'])); ?>
		<?php } ?>
		</div>
<?php 
	}?>
</div>
<?php
}?>