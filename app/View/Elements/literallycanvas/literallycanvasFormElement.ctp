<?php
echo $this->Html->css('/css/literallycanvas/literally', null, array('inline' => false));
echo $this->Html->script('/js/underscore/underscore-1.4.2', array('inline' => false));
echo $this->Html->script('/js/literallycanvas/literallycanvas', array('inline' => false));
?>

<div class="literally"><canvas></canvas></div>

<?php
//echo $this->Form->create(null, array('id' => 'saveCanvasImage'));
echo $this->Form->hidden('canvasImageData', array('id' => 'canvasImageData'));
//echo $this->Form->submit('Save', array('id' => 'saveCanvas', 'class' => 'btn'));
//echo $this->Form->end();
?>

<script type="text/javascript">
	$( document ).ready( function() {
		// disable scrolling on touch devices so we can actually draw
		$( document ).bind( 'touchmove', function( e ) {
			if ( e.target === document.documentElement ) {
				return e.preventDefault();
			}
		} );

		// the only LC-specific thing we have to do
		$('.literally').literallycanvas( {imageURLPrefix: '/img/literallycanvas'} );
		
		$('#canvasImageData').closest('form').submit(function(){
			$('#canvasImageData').val( $('.literally').canvasForExport().toDataURL() );
		});
	} );
</script>
