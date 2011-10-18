<div class="galleryImages form">
  <h2><?php __('Edit '); echo $this->data['GalleryImage']['caption']; ?></h2>
  <img src="<?php echo $this->data['GalleryImage']['dir'].'thumb/small/'.$this->data['GalleryImage']['filename']; ?>" />	    
<?php echo $this->Form->create('GalleryImage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><?php __('Edit Image'); ?></legend>
	<?php
		echo $this->Form->input('GalleryImage.id');
		echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->data['GalleryImage']['gallery_id']));
		echo $this->Form->input('GalleryImage.filename', array('type' => 'file'));
		echo $this->Form->input('GalleryImage.caption', array('type' => 'text'));
		echo $this->Form->input('GalleryImage.description', array('type' => 'richtext'));
		#echo $this->Form->input('GalleryImage.alt');
		echo $this->Form->input('dir', array('type' => 'hidden'));
	    echo $this->Form->input('mimetype', array('type' => 'hidden'));
	    echo $this->Form->input('filesize', array('type' => 'hidden'));
		echo $this->Form->end('Submit');
	?>
    </fieldset>
</div>

<?php 
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('List Galleries', true), array('controller' => 'galleries', 'action' => 'index')),
			)
		),
	)));
?>