
<?php echo $this->Html->css('/css/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php echo $this->Html->script('/js/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<style type="text/css">
	[data-template-tag*="config"] {
		padding: 1em;
	}
	[data-template-tag*="element"] {
		cursor: move;
	}
	.over {
		background: #eee;
	}
</style>
<script type="text/javascript">
$(function() {
	// temp editable element styling
	$('[data-template-tag*="config"]').css('border', '4px solid red');
	$('[data-template-tag*="config"] [data-template-tag*="element"]').css('border', '4px solid blue');

	$('[data-template-tag*="config"] *').click(function(e) {
		 e.preventDefault();
	});
	var plugin = '<?php echo $this->request->plugin; ?>';
	var controller = '<?php echo $this->request->controller; ?>';
	var id = '<?php echo $this->request->params['pass'][0]; ?>';
	
	$('[data-template-tag*="config"]').sortable({
		connectWith: '[data-template-tag*="config"]',
		stop: function(event, elem) {
        	showSaveBox();
		}
	}).disableSelection();
	
	$('body').on('click', '#templateSaveBtn', function() {
		saveBoxes();
	});
	
	function showSaveBox() {
		if ($("#templateSaveBtn").is(":visible") ) {
			// do nothing its there
		} else {
			$('body').prepend('<a href="#" id="templateSaveBtn" class="btn btn-success">Save</a>');
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
			success: function() {
				console.log('responded');
				$.each($('[data-template-tag*="config"]'), function( index ) {
					$(this).html(originals[index]);
				});
			},
			dataType: 'html'
		});
		$('#templateSaveBtn').remove();
	}
});
</script>
