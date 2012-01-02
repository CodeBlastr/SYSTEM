<?php
# if its edit page we add a few actions
if (strpos($this->request->url, 'edit/')) { ?>
	<ul class="actions gallerySlideActions">
    	<li><?php echo  $this->Html->link(__('Make Thumb', true), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'make_thumb', $galleryId, $slideId), array('class' => 'action', 'title' => 'Make this image the thumbnail for this gallery.'));?></li>
        <li><?php echo $this->Html->link(__('Edit', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'edit', $slideId), array('class' => 'action')); ?></li>
        <li><?php echo $this->Html->link(__('Delete', true), array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $slideId), array('class' => 'action thumbDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $slideId)); ?></li>
    </ul>
<?php
} ?>