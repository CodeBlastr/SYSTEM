<div class="clearfix">
	<?php echo $this->Form->create('Webpage', array('type' => 'file'));?>
	<div class="clearfix">
		<div class="webpages form col-md-9">
			<fieldset>
		    	<?php
				echo $this->Form->input('Webpage.type', array('type' => 'hidden', 'value' => $parent['Webpage']['type']));
				echo $this->Form->input('Webpage.parent_id', array('type' => 'hidden', 'value' => $parent['Webpage']['id']));
				echo $this->Form->input('Webpage.name', array('label' => 'Internal Page Name'));
				echo $this->Form->input('Webpage.content', array('type' => 'richtext')); ?>
			</fieldset>
		</div>
		<div class="col-md-3" id="webpages-sidebar">
			<div class="panel"><?php // this extra div is a bootstra 3 bug, that appears fixed on github but not in the dist yet ?>
				<h4 data-toggle="collapse" data-target=".seo-group" data-parent="#webpages-sidebar"><?php echo __('Search Engine Optimization');?></h4>
				<hr />
				<div class="seo-group collapse in">
			    	<?php echo $this->Element('forms/alias', array('formId' => '#WebpageAddForm', 'nameInput' => '#WebpageName', 'dataDisplay' => '[for=WebpageName]')); // must have the alias behavior attached to work ?>
			    	<?php echo $this->Form->input('Webpage.title', array('label' => 'SEO Title')); ?>
					<?php echo $this->Form->input('Webpage.keywords', array('label' => 'SEO Keywords', 'type' => 'text')); ?>
					<?php echo $this->Form->input('Webpage.description', array('label' => 'SEO Description', 'type' => 'text')); ?>
				</div>
				
				<h4 data-toggle="collapse" data-target=".img-group" data-parent="#webpages-sidebar"><?php echo __('Featured Image'); ?></h4>
				<hr />
				<div class="img-group collapse">
					<?php echo $this->Form->input('GalleryImage.filename', array('type' => 'file')); ?>
				</div>
	
				<h4 data-toggle="collapse" data-target=".access-group" data-parent="#webpages-sidebar"><?php echo __('<span class="hoverTip" title="User role site privileges are used by default. Choose an option to restrict access to only the chosen group for this specific page.">Access</span>');?></h4>
				<hr />
				<div class="access-group collapse">
					<?php echo $this->Form->input('WebpageMenuItem.parent_id', array('empty' => '-- Select Menu --', 'label' => __('Menu Location'))); ?>
					<?php echo $this->Form->input('WebpageMenuItem.item_text', array('label' => __('Menu Text'))); ?>
					<p>Check these boxes to restrict access to only the chosen group(s) for this specific page.</p>
			    	<?php echo $this->Form->input('RecordLevelAccess.UserRole', array('label' => 'User Roles', 'type' => 'select', 'multiple' => 'checkbox', 'options' => $userRoles)); ?>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end('Add Page');?>
</div>

<script type="text/javascript">
	// let's try to do some handy auto form filling out 
	$('#WebpageAddForm').change(function() {
		// menu item
		if( $('#WebpageMenuItemItemText').val().length == 0 ) {
			$('#WebpageMenuItemItemText').val($('#WebpageName').val())
		}
		// seo title
		if( $('#WebpageTitle').val().length == 0 ) {
			$('#WebpageTitle').val($('#WebpageName').val())
		}
	})
	
	var editor = CKEDITOR.replace('WebpageContent')
	editor.on('blur', function(evt){
		keywords = $(editor.getData()).text().replace(/[^\w\s]|_/g, "").replace(/\s+/g, ", ").trim(this).substring(0, 100).trim(this)
		if( $('#WebpageKeywords').val().length == 0 ) {
			$('#WebpageKeywords').val(keywords)
		}
		description = 
		keywords = $(editor.getData()).text().trim(this).substring(0, 200).trim(this)
		if( $('#WebpageDescription').val().length == 0 ) {
			$('#WebpageDescription').val(keywords)
		}
	})

</script>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	'Add Content Page',
)));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Webpages',
		'items' => array(
			 $this->Html->link(__('List'), array('action' => 'index')),									 
			 )
		)
	))); ?>