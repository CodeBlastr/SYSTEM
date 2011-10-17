<div class="galleries form">
  <h2><?php __('Edit '); echo $gallery['Gallery']['name']; __(' Gallery '); ?></h2>
<?php echo $form->create('Gallery', array('enctype'=>'multipart/form-data'));?>
	<fieldset id="galleryFields">
 		<legend class="toggleClick"><?php __('Edit Gallery Info'); ?></legend>
		<?php
		echo $form->input('Gallery.id');
		echo $form->input('Gallery.name');
		echo $form->input('Gallery.type', array('empty' => true));
		echo $form->input('Gallery.model', array('type' => 'hidden'));
		echo $form->input('Gallery.foreign_key', array('type' => 'hidden'));
		echo $form->input('Gallery.description', array('type' => 'richtext'));
		echo $form->end('Submit');
		?>
    </fieldset>
    
    
	<?php echo $this->element($gallery['Gallery']['type'], array('plugin' => 'galleries', 'id' => $gallery['Gallery']['id'])); ?>

    
<?php echo $form->create('GalleryImage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Add Image'); ?></legend>
	<?php
		echo $form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $gallery['Gallery']['id']));
		echo $form->input('Gallery.model', array('type' => 'hidden'));
		echo $form->input('Gallery.foreign_key', array('type' => 'hidden'));
		echo $form->input('GalleryImage.filename', array('type' => 'file'));
		echo $form->input('GalleryImage.caption', array('type' => 'text'));
		echo $form->input('GalleryImage.description', array('type' => 'richtext'));
		#echo $form->input('GalleryImage.alt');
		echo $form->input('dir', array('type' => 'hidden'));
	    echo $form->input('mimetype', array('type' => 'hidden'));
	    echo $form->input('filesize', array('type' => 'hidden'));
	?>
    </fieldset>
<?php echo $form->end('Submit'); ?>
    
  
</div>
<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('List Galleries', true), array('action' => 'index')),
			)
		),
	)
);
?>
<?php #debug($this->data); ?>
