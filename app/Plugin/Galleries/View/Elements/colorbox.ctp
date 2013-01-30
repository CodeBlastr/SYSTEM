<?php
# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__ELEMENT_GALLERIES_COLORBOX_'.$instance)) {
	extract(unserialize(constant('__ELEMENT_GALLERIES_COLORBOX_'.$instance)));
} else if (defined('__ELEMENT_GALLERIES_COLORBOX')) {
	extract(unserialize(__ELEMENT_GALLERIES_COLORBOX));
}

if (!empty($gallery['GalleryImage'][0])) { 
	# put default variable setups here
	
	# additional files needed for gallery display
	echo $this->Html->css('/galleries/css/colorbox/colorbox', '', array('inline' => 0));
	echo $this->Html->script('/galleries/js/colorbox/jquery.colorbox-min', array('inline' => 0));		
	echo $this->Html->scriptBlock('
		$(document).ready(function(){
			$("a[rel=\'example4\']").colorbox({
				slideshow:true,
			});
		});', array('inline' => 0)); ?>
        
    <div class="colorboxGallery">  
        <?php 
        foreach ($gallery['GalleryImage'] as $slide) { ?>
            <div id="galleryImage<?php echo $slide['id']; ?>" class="colorBoxGallerImage colorbox galleryImage">
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
                array('plugin' => 'users', 'controller' => 'users', 'action' => 'view',$gallery['Gallery']['foreign_key']), 
                array(
                    'escape' => false,
                    'id' => 'galleryImage' . $slide['id'],
                    'class' => 'jqzoom2 zoomable galleryImage',
                    'title' => $slide['caption'],
                    'rel' => 'example4',
                    ));   
    
                    
            echo $this->Element('actions', array('galleryId' => $gallery['Gallery']['id'], 'slideId' => $slide['id']), array('plugin' => 'galleries')); ?>
            </div>
        <?php 
        } // end images loop ?>
    </div>
<?php
} // end gallery image check ?>
