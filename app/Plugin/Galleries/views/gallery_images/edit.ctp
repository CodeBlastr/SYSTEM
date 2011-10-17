<div class="galleryImages form">
  <h2><?php __('Edit '); echo $this->data['GalleryImage']['caption']; ?></h2>
  <img src="<?php echo $this->data['GalleryImage']['dir'].'thumb/small/'.$this->data['GalleryImage']['filename']; ?>" />	    
<?php echo $form->create('GalleryImage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Edit Image'); ?></legend>
	<?php
		echo $form->input('GalleryImage.id');
		echo $form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->data['GalleryImage']['gallery_id']));
		echo $form->input('GalleryImage.filename', array('type' => 'file'));
		echo $form->input('GalleryImage.caption', array('type' => 'text'));
		echo $form->input('GalleryImage.description', array('type' => 'richtext'));
		#echo $form->input('GalleryImage.alt');
		echo $form->input('dir', array('type' => 'hidden'));
	    echo $form->input('mimetype', array('type' => 'hidden'));
	    echo $form->input('filesize', array('type' => 'hidden'));
		echo $form->end('Submit');
	?>
    </fieldset>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('List Galleries', true), array('controller' => 'galleries', 'action' => 'index')),
			)
		),
	)
);
?>