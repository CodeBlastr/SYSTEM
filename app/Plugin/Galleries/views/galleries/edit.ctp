<div class="galleries form">
  <h2><?php __('Edit '); echo $gallery['Gallery']['name']; __(' Gallery '); ?></h2>
<?php echo $this->Form->create('Gallery', array('enctype'=>'multipart/form-data'));?>
	<fieldset id="galleryFields">
 		<legend class="toggleClick"><?php __('Edit Gallery Info'); ?></legend>
		<?php
		echo $this->Form->input('Gallery.id');
		echo $this->Form->input('Gallery.name');
		echo $this->Form->input('Gallery.type', array('empty' => true));
		echo $this->Form->input('Gallery.model', array('type' => 'hidden'));
		echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden'));
		echo $this->Form->input('Gallery.description', array('type' => 'richtext'));
		echo $this->Form->end('Submit');
		?>
    </fieldset>
    
    
	<?php echo $this->element($gallery['Gallery']['type'], array('plugin' => 'galleries', 'id' => $gallery['Gallery']['id'])); ?>

    
<?php echo $this->Form->create('GalleryImage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Add Image'); ?></legend>
	<?php
		echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $gallery['Gallery']['id']));
		echo $this->Form->input('Gallery.model', array('type' => 'hidden'));
		echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden'));
		echo $this->Form->input('GalleryImage.filename', array('type' => 'file'));
		echo $this->Form->input('GalleryImage.caption', array('type' => 'text'));
		echo $this->Form->input('GalleryImage.description', array('type' => 'richtext'));
		#echo $this->Form->input('GalleryImage.alt');
		echo $this->Form->input('dir', array('type' => 'hidden'));
	    echo $this->Form->input('mimetype', array('type' => 'hidden'));
	    echo $this->Form->input('filesize', array('type' => 'hidden'));
	?>
    </fieldset>
<?php echo $this->Form->end('Submit'); ?>
    
  
</div>
<?php 
// set the contextual menu items
$this->Menu->setValue(array(
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
