<?php if (is_array($editFields)) : ?>

<script type="text/javascript">
$(function() {
	<?php 
	foreach($editFields as $editField) : 
		if (!empty($editField['plugin'])) {
			$plugin = $editField['plugin'].'/';
		} else {
			$plugin = '';
		}
	?>
    $(".edit[name='<?php echo $editField['name']; ?>'][id='<?php echo $editField['tagId']; ?>']").editable('/<?php echo $plugin; ?><?php echo $editField['controller']; ?>/ajax_edit', {
         id        : '<?php echo $editField['fieldId']; ?>',
         name      : '<?php echo $editField['fieldName']; ?>',
		 <?php if (isset($editField['loadurl'])) { ?>
		 loadurl   : '<?php echo $editField['loadurl']; ?>',
		 <?php } ?>
         type      : '<?php echo $editField['type']; ?>',
         cancel    : 'Cancel',
         submit    : 'Save',
		 indicator : 'Saving...',
         tooltip   : 'Click to edit'
    });
	<?php endforeach; ?>

	//dialog/modal/lightbox if you ever want to use it
	//$("#tabs").dialog({ modal: true });
	
	
	
	// file: /app/webroot/js/jquery-common.js

/* class exists
	if($('.confirm_delete').length) {
	        // add click handler
		$('.confirm_delete').click(function(){
			// ask for confirmation
			var result = confirm('Are you sure you want to permanently delete?');
			
			// show loading image
			$('#loadingimg').show();
			$('#flashMessage').fadeOut();
			
			// get parent row
			var row = $(this).parents('div');
			
			// do ajax request
			if(result) {
				$.ajax({
					type:"POST",
					url:$(this).attr('href'),
					data:"ajax=1",
					dataType: "json",
					success:function(response){
						// hide loading image
						$('.ajax_loader').hide();
						
						// hide table row on success
						if(response.success == true) {
							row.fadeOut();
						}
						
						// show respsonse message
						if( response.msg ) {
							$('#ajax_msg').html( response.msg ).show();
						} else {
							$('#ajax_msg').html( "<p id='flashMessage' class='flash_bad'>An unexpected error has occured, please refresh and try again</p>" ).show();
						}
					}
				});
			}
		return false;
		});
	}  */ 
	
 //console.info($('body'));
});
</script>

<?php endif; ?>