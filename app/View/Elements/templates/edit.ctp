
<?php echo $this->Html->css('/css/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php echo $this->Html->css('/webpages/menus/css/nestedSortable'); ?>
<?php echo $this->Html->script('/js/jquery-ui/jquery-ui-1.9.2.custom.min'); ?>
<?php echo $this->Html->script('/webpages/menus/js/jquery.ui.nestedSortable'); ?>

<script type="text/javascript">
$(function() {
	$('[data-template-tag*="config"]').css('border', '4px solid red');
	$('[data-template-tag*="config"] [data-template-tag*="element"]').css('border', '4px solid blue');
    // // maybe this is for editing item values???
	// $('.sortableMenu a').click(function(e) {
		// e.preventDefault();
	// });
// 
	// $('.sortableMenu').nestedSortable({
		// forcePlaceholderSize: true,
		// listType: 'ul',
		// handle: 'div',
		// helper: 'clone',
		// opacity: .6,
    	// placeholder: 'placeholder',
        // rootID: '<?php echo $this->request->data['WebpageMenu']['id']; ?>',
		// items: "li",
		// delay: 100,
		// tolerance: 'pointer',
		// toleranceElement: '> div',
		// update: function(event, ui) {
			// //$('#loadingimg').show();
		 	// var order = $('ul.sortableMenu').nestedSortable('toArray');
			// $.post('/webpages/webpage_menu_items/sort.json', {order:order}, 
				   // function(data){
					  	// var n = 1;
						// $.each(data, function(i, item) {
							// $('td.'+item).html(n);
							// n++;
						// });	
						// //$('#loadingimg').hide()
				   // }
			// );
		// }
	// });
});
</script>
