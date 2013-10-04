<div class="galleries form row-fluid">
	<div class="galleries form pull-left span8">
		<div class="galleryPreview well clearfix">
			<?php echo $this->Element('gallery', array('model' => $model, 'foreignKey' => $foreignKey), array('plugin' => 'galleries')); ?>
		</div>
	</div>
	
	<div class="galleryImages pull-right index span4">
		<div class="accordion" id="accordion">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Add image</a>
				</div>
				<div id="collapseOne" class="accordion-body collapse">
					<div class="accordion-inner">
					<?php
					echo $this->Form->create('GalleryImage', array('enctype' => 'multipart/form-data')); 
					echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->request->data['Gallery']['id']));
					echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
					echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
					echo $this->Form->input('GalleryImage.filename', array('label' => 'Upload File', 'type' => 'file'));
					echo $this->Form->input('GalleryImage.caption', array('type' => 'text'));
					echo $this->Form->input('GalleryImage.description');
					echo $this->Form->end('Submit'); ?>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><?php echo __('Existing Media'); ?></a>
				</div>
				<div id="collapseTwo" class="accordion-body collapse in">
					<div class="accordion-inner">
					<?php
					foreach ($this->request->data['GalleryImage'] as $image) {
						echo '<div class="media clearfix">';
						echo !empty($image['_thumb']) ? $this->Html->image($image['_thumb'], array('class' => 'pull-left', 'width' => $this->request->data['GallerySettings']['smallImageWidth'], 'height' => $this->request->data['GallerySettings']['smallImageHeight'])) : $this->Html->link($this->Html->image($image['dir'] . 'thumb' . DS . 'small' . DS . $image['filename']), $image['dir'] . $image['filename'], array('class' => 'pull-left', 'escape' => false));
						echo '<div class="media-body">';
						echo $this->Html->link('<i class="icon-thumbs-up"></i>', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'make_thumb', $image['gallery_id'], $image['id']), array('title' => 'Make This Image the Thumbnail', 'escape' => false));
						echo $this->Html->link('<i class="icon-arrow-down"></i>', array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'down', $image['id']), array('title' => 'Move Order Down', 'escape' => false));
						echo $this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'edit', $image['id']), array('title' => 'Edit Image', 'escape' => false));
						echo $this->Form->postLink('<i class="icon-remove-sign"></i>', array('plugin' => 'galleries', 'controller' => 'gallery_images', 'action' => 'delete', $image['id']), array('title' => 'Delete Image', 'escape' => false), __('Are you sure?'));
						echo '</div>';
						echo '</div>';
					} ?>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><?php echo __('Add Multiple Images'); ?></a>
				</div>
				<div id="collapseThree" class="accordion-body collapse">
					<div class="accordion-inner">
					<?php
					echo $this->Form->create('GalleryImage', array('enctype' => 'multipart/form-data')); 
					echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->request->data['Gallery']['id']));
					echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
					echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
					echo $this->Form->input('GalleryImage.serverfile', array('label' => 'Server File(s)', 'placeholder' => 'Click here to add images', 'after' => '<div id="kcfinder_div"></div>', 'onclick' => 'openKCFinder(this)', 'style' => 'cursor:pointer'));
					echo $this->Form->end('Submit'); ?>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><?php echo __('Add Video'); ?></a>
				</div>
				<div id="collapseFour" class="accordion-body collapse">
					<div class="accordion-inner">
					<?php
					echo $this->Form->create('GalleryImage', array('enctype' => 'multipart/form-data')); 
					echo $this->Form->input('GalleryImage.gallery_id', array('type' => 'hidden', 'value' => $this->request->data['Gallery']['id']));
					echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
					echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
					echo $this->Form->input('GalleryImage.mimetype', array('type' => 'hidden', 'value' => 'video'));
					echo $this->Form->input('GalleryImage.filename', array('label' => 'Paste video embed link'));
					echo $this->Form->end('Submit'); ?>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><?php echo __('Options'); ?></a>
				</div>
				<div id="collapseFive" class="accordion-body collapse">
					<div class="accordion-inner">
					<?php 
					echo $this->Form->create('Gallery', array('enctype' => 'multipart/form-data'));
					echo $this->Form->input('Gallery.id');
					echo $this->Form->input('Gallery.name');
					echo $this->Form->hidden('Gallery.model', array('value' => $model));
					echo $this->Form->hidden('Gallery.foreign_key', array('value' => $foreignKey));
					echo $this->Form->input('Gallery.description');
					echo $this->Form->input('Gallery.type', array('empty' => true));
					echo $this->Form->input('Gallery.thumb_width');
					echo $this->Form->input('Gallery.thumb_height');
					echo $this->Form->input('Gallery.medium_width');
					echo $this->Form->input('Gallery.medium_height');
					echo $this->Form->input('Gallery.full_width');
					echo $this->Form->input('Gallery.full_height');
					echo $this->Form->input('Gallery.conversion_type', array('type' => 'select', 'options' => $conversionTypes, 'empty' => true));
					echo $this->Form->end('Submit'); ?>
					</div>
				</div>
			</div>
		</div>
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
	

  
<style type="text/css">
	#kcfinder_div {
		background: none repeat scroll 0 0 #E0DFDE;
		border: 2px solid #3687E2;
		border-radius: 6px 6px 6px 6px;
		display: none;
		height: 18em;
		padding: 1px;
		position: absolute;
		right: 4em;
		width: 40em;
		z-index: 3;
	}
	.kcFinderClose {
		float: right;
		font-size: 0.8em;
	}
</style>
 
<script type="text/javascript">
	$(function() {
		$('a.accordion-toggle').click(function() {
			$('.accordion-body').css('overflow', 'hidden');
		});
	});
	
	function openKCFinder(field) {
	    var div = document.getElementById('kcfinder_div');
	    // makes the ckfinder field filemanager viewable in the accordion
	    $('#collapseThree').css('overflow', 'visible');
	    
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
	    div.innerHTML = '<span class="kcFinderClose"><a href="#" onclick="openKCFinder()">[x] close</a></span><iframe name="kcfinder_iframe" src="/js/kcfinder/browse.php?type=img&kcfinderuploadDir=<?php echo str_replace('sites' . DS, '', SITE_DIR); ?>
			&CKEditor=GalleryImageDescription&langCode=en" frameborder="0" width="100 % " height="91 % " marginwidth="0" marginheight="0" scrolling="no"></iframe>';
			div.style.display = 'block';
	}
</script>