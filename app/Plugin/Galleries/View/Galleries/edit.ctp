<div class="galleries form">
<?php echo $this->Form->create('Gallery', array('enctype'=>'multipart/form-data'));?>
	<fieldset id="galleryFields">
 		<legend class="toggleClick"><h2><?php echo !empty($this->request->data['Gallery']['name']) ? $this->request->data['Gallery']['name']: null; echo __(' Gallery Info'); ?></h2></legend>
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
    
    
	<?php echo !empty($this->request->data['Gallery']['id']) ? $this->element($this->request->data['Gallery']['type'], array('id' => $this->request->data['Gallery']['id']), array('plugin' => 'galleries')) : null; ?>

    
<?php echo $this->Form->create('GalleryImage', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
 		<legend><h3><?php echo __('Add Image'); ?></h3></legend>
	<?php
		echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->request->data['Gallery']['id']));
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
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('List Galleries', true), array('action' => 'index')),
			)
		),
	)));
?>
<?php #debug($this->request->data); ?>
