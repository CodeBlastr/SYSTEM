<div class="menus view">
    <h3><?php echo $menu['WebpageMenu']['name']; ?></h3>
    <div class="related">
        <?php 
        $this->Tree->addTypeAttribute('data-identifier', $menu['WebpageMenu']['id'], null, 'previous');
        echo $this->Tree->generate($menuItems, array(
    			'model' => 'WebpageMenuItem', 
    			'alias' => 'item_text', 
    			'class' => 'sortable sortableMenu '.$menu['WebpageMenu']['type'], 
    			'id' => 'menu' . $menu['WebpageMenu']['id'], 
    			'element' => 'item', 
    			'elementPlugin' => 'webpages')); ?>
    </div>
</div>


<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
    array(
		'heading' => 'Menus',
		'items' => array(
            $this->Html->link(__('All'), array('action' => 'index')),
    		$this->Html->link(__('Edit'), array('action' => 'edit', $menu['WebpageMenu']['id'])),
            $this->Html->link(__('Add'), array('action' => 'add')),
			$this->Html->link(__('Delete '), array('action' => 'delete', $menu['WebpageMenu']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $menu['WebpageMenu']['id'])),		
            )
		),
    array(
    	'heading' => 'Items',
		'items' => array(
			$this->Html->link(__('Add Link'), array('controller' => 'webpage_menu_items', 'action' => 'add', $menu['WebpageMenu']['id'])),
            $this->Html->link(__('List Links'), array('controller' => 'webpage_menu_items', 'action' => 'index', $menu['WebpageMenu']['id']))
            )
		),
	))); ?>


<?php echo $this->Html->css('/css/jquery-ui/jquery-ui-1.8.13.custom'); ?>
<?php echo $this->Html->css('/webpages/menus/css/nestedSortable'); ?>
<?php echo $this->Html->script('/js/jquery-ui/jquery-ui-1.8.13.custom.min'); ?>
<?php echo $this->Html->script('/webpages/menus/js/jquery.ui.nestedSortable'); ?>

<script type="text/javascript">
$(function() {
    // maybe this is for editing item values???
	$('.sortableMenu a').click(function(e) {
		e.preventDefault();
	});

	$('.sortableMenu').nestedSortable({
		forcePlaceholderSize: true,
		listType: 'ul',
		handle: 'div',
		helper: 'clone',
		opacity: .6,
        rootID: '<?php echo $menu['WebpageMenu']['id']; ?>',
		items: "li",
		delay: 100,
		tolerance: 'pointer',
		toleranceElement: '> div',
		update: function(event, ui) {
			//$('#loadingimg').show();
		 	var order = $('ul.sortableMenu').nestedSortable('toArray');
			$.post('/webpages/webpage_menu_items/sort.json', {order:order}, 
				   function(data){
					  	var n = 1;
						$.each(data, function(i, item) {
							$('td.'+item).html(n);
							n++;
						});	
						//$('#loadingimg').hide()
				   }
			);
		}
	});
});
</script>