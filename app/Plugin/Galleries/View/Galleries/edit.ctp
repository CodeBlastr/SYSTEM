<div class="galleries form">
	<div class="galleryImages well pull-right index span3">
		<h3>Images</h3>
		<table>
		<?php
		foreach ($this->request->data['GalleryImage'] as $image) {
			echo '<tr><td>';
			echo $this->Html->link($this->Html->image($image['dir'] . 'thumb' . DS . 'small' . DS . $image['filename']), $image['dir'] . $image['filename'], array('escape' => false));
			echo '</td><td>';
			echo $this->Html->link('Move Down', array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'down', $image['id']), array('class' => 'btn btn-small btn-info'));
			echo '</td><td>';
			echo '</td><td>';
			echo $this->Form->postLink('Delete', array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $image['id']), array('class' => 'btn btn-small btn-danger'), __('Are you sure?'));
			echo '</td><td>';
			echo '</tr>';
		} ?>
		</table>
	</div>
	<div class="galleries form pull-left span8">
		<?php /*
		<h3><?php echo __('Gallery Preview'); ?></h3>
		<div class="preview galleryPreview"><?php echo $this->Element('gallery', array('model' => $model, 'foreignKey' => $foreignKey), array('plugin' => 'galleries')); ?></div> */ ?>
	
		<?php echo $this->Form->create('Gallery', array('enctype'=>'multipart/form-data'));?>
		<fieldset id="galleryFields">
	 		<legend class="toggleClick"><?php echo __('Edit Gallery Options'); ?></legend>
			<?php
			echo $this->Form->input('Gallery.id');
			echo $this->Form->input('Gallery.name');
			echo $this->Form->hidden('Gallery.model', array('value' => $model));
			echo $this->Form->hidden('Gallery.foreign_key', array('value' => $foreignKey));
			echo $this->Form->input('Gallery.description', array('type' => 'richtext')); ?>
	        
	      	<legend><?php echo __('Gallery Options'); ?></legend>
	        
	    	<?php
			echo $this->Form->input('Gallery.type', array('empty' => true));
			echo $this->Form->input('Gallery.thumb_width');
			echo $this->Form->input('Gallery.thumb_height');
			echo $this->Form->input('Gallery.medium_width');
			echo $this->Form->input('Gallery.medium_height');
			echo $this->Form->input('Gallery.full_width');
			echo $this->Form->input('Gallery.full_height');
			echo $this->Form->input('Gallery.conversion_type', array('type' => 'select', 'options' => $conversionTypes, 'empty' => true));
			echo $this->Form->end('Submit'); ?>
	        
		</fieldset>
		<?php echo $this->Form->create('GalleryImage', array('enctype'=>'multipart/form-data'));?>
		<fieldset>
	 		<legend><?php echo __('Add Images'); ?></legend>
			<?php
			echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->request->data['Gallery']['id']));
			echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
			echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
			echo $this->Form->input('GalleryImage.filename', array('label' => 'Upload File', 'type' => 'file'));
			echo $this->Form->input('GalleryImage.serverfile', array('label' => 'Server File(s)', 'after' => '<div id="kcfinder_div"></div>', 'onclick' => 'openKCFinder(this)', 'style' => 'cursor:pointer'));		
			echo $this->Form->input('GalleryImage.caption', array('type' => 'text'));
			echo $this->Form->input('GalleryImage.description', array('type' => 'richtext'));
			#echo $this->Form->input('GalleryImage.alt');
			echo $this->Form->end('Submit'); ?>
	    </fieldset>
	</div>
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Galleries',
		'items' => array(
			$this->Html->link(__('View', true), array('action' => 'view', $model, $foreignKey)),
			$this->Html->link(__('List', true), array('action' => 'index'), array('class' => 'index')),
			$this->Html->link(__('Add'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'add'), array('class' => 'add')),
			$this->Html->link(__('Delete'), array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'delete', $this->Form->value('Gallery.id')), array('class' => 'delete'), array('class' => 'index'), 'Are you sure you want to permanently delete?'),
			)
		),
	))); ?>
    
    
 <?php /*
 
<style type="text/css">
#kcfinder_div {
    display: none;
    position: absolute;
    width: 670px;
    height: 400px;
    background: #e0dfde;
    border: 2px solid #3687e2;
    border-radius: 6px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    padding: 1px;
	z-index: 3;
}
.kcFinderClose {
	float: right;
	font-size: 0.8em;
}
</style>
 
<script type="text/javascript">
function openKCFinder(field) {
    var div = document.getElementById('kcfinder_div');
    if (div.style.display == "block") {
        div.style.display = 'none';
        div.innerHTML = '';
        return;
	}
	window.KCFinder = {
        callBackMultiple: function(files) {
            window.KCFinder = null;
            field.value = "";
            for (var i = 0; i < files.length; i++)
                field.value += files[i] + ",";
            div.style.display = 'none';
            div.innerHTML = '';
        }
    };
    div.innerHTML = '<span class="kcFinderClose"><a href="#" onclick="openKCFinder()">[x] close</a></span><iframe name="kcfinder_iframe" src="/js/kcfinder/browse.php?type=images&kcfinderuploadDir=<?php echo str_replace('sites'.DS, '', SITE_DIR); ?>&CKEditor=GalleryImageDescription&langCode=en" frameborder="0" width="100%" height="95%" marginwidth="0" marginheight="0" scrolling="no"></iframe>';
    div.style.display = 'block';
}
</script> */ ?>