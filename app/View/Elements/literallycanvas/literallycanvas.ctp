<?php
// configuration
$id = !empty($id) ? $id : '';

// queue required files
echo $this->Html->css('/css/literallycanvas/literally', null, array('inline' => false));
echo $this->Html->script('/js/underscore/underscore-1.4.2', array('inline' => false));
echo $this->Html->script('/js/literallycanvas/literallycanvas', array('inline' => false));
?>

<div class="literally"><canvas id="<?php echo $id ?>"></canvas></div>

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
	} );
</script>
