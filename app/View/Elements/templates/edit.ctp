
<?php echo $this->Html->css('/css/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php echo $this->Html->script('/js/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<style type="text/css">
	[data-template-tag*="config"] {
		min-height: 1em;
		min-width: 1em;
	}
	[data-template-tag*="element"], .handle {
		cursor: move;
		list-style-type:none;
		padding: 0;
		margin: 0;
	}
	.templateMessage {
	    left: 50%;
	    margin: -150px;
	    position: fixed;
	    top: 100%;
	    width: 300px;
	    z-index: 99;
	    text-align: center;
	}
</style>
<script type="text/javascript">
$(function() {
	// temp editable element styling
	startMessage = '<span class="handle"><i class="icon-move"></i></span> Drag elements to your desired order. <a class="btn btn-mini" href="<?php echo str_replace('/template', '', $this->request->here); ?>">Exit</a>';
	$('[data-template-tag*="config"]').css('border', '1px solid #aaa');
	$('[data-template-tag*="config"] [data-template-tag*="element"]').css('border', '1px dashed #ccc');
	$('body').append('<div class="templateMessage alert alert-info">'+startMessage+'</div>');

	$('[data-template-tag*="config"] *').click(function(e) {
		 e.preventDefault();
	});
	var plugin = '<?php echo $this->request->plugin; ?>';
	var controller = '<?php echo $this->request->controller; ?>';
	var id = '<?php echo $this->request->params['pass'][0]; ?>';
	
	$('.templateMessage').draggable({
		handle: '.handle'
	});
	
	$('[data-template-tag*="config"]').sortable({
		connectWith: '[data-template-tag*="config"]',
		stop: function(event, elem) {
        	showSaveBox();
		},
		over: function(event, ui) {
			console.log('over ' + ui);
		}
	}).disableSelection();
	
	$('body').on('click', '#templateSaveBtn', function() {
		saveBoxes();
	});
	
	function showSaveBox() {
		if ($("#templateSaveBtn").is(":visible") ) {
			// do nothing its there
		} else {
			$('.templateMessage').html('<a href="#" id="templateSaveBtn" class="btn btn-success">Save</a> <a href="#" onclick="location.reload()" id="templateCancelBtn" class="btn btn-warning">Cancel</a>');
		}
	}
	
	
	function saveBoxes() {
		var originals = new Array();
		$('[data-template-tag*="config"]').each(function( index ) {
			originals[index] = $(this).html();
		});
		
		$.each($('[data-template-tag*="element"]'), function( index ) {
			element = $(this).attr('data-template-tag');
			$(this).replaceWith('{' + element + '}');
		});
		
		var boxes = new Array();
		$('[data-template-tag*="config"]').each(function( index ) {
			boxes[index] = $(this).html();
		});
		$.ajax({
			type: 'POST',
			url: '/'+plugin+'/'+controller+'/template/'+id,
			data:'data=' + JSON.stringify(boxes),
			success: function(data) {
				if (data == 'true') {
					$('.templateMessage').removeClass('alert-info');
					$('.templateMessage').addClass('alert-success');
					$('.templateMessage').html('Saved');
					setTimeout(function() {
						$('.templateMessage').removeClass('alert-success');
						$('.templateMessage').addClass('alert-info');
						$('.templateMessage').html(startMessage);
					}, 1500);
				}
				$.each($('[data-template-tag*="config"]'), function( index ) {
					$(this).html(originals[index]);
				});
			},
			dataType: 'html'
		});
		$('#templateSaveBtn, #templateCancelBtn').remove();
	}
});
</script>
