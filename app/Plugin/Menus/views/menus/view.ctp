<div class="menus view">
    <h3><?php echo $menu['Menu']['name']; ?></h3>
  <div class="related">
    <?php 
echo $this->Tree->generate($menuItems, array(
			'model' => 'MenuItem', 
			'alias' => 'item_text', 
			'class' => 'menu '.$menu['Menu']['type'], 
			'id' => 'menu'.$menu['Menu']['id'], 
			'element' => 'item', 
			'elementPlugin' => 'menus'));
?>
	<?php 
		echo $this->Form->create('MenuItem', array('action' => 'edit', 'class' => 'hide MenuItemForm'));
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('item_text', array('label' => 'Link Text'));
		echo $this->Form->input('item_url', array('label' => 'Url'));
		echo $this->Form->end(__('Save', true));
		
		echo $this->Form->create('MenuItem', array('action' => 'delete', 'class' => 'hide MenuItemForm'));
		echo $this->Form->input('id', array('type' => 'hidden', 'id' => 'MenuItemDeleteId'));
		echo $this->Form->end(__('Delete', true));
	?>
	</div>
    <div class="actions">
      <ul>
        <li>
          <?php echo __('Menus'); ?>
        </li>
        <li><?php echo $this->Html->link(__('Refresh', true), array('', $menu['Menu']['id']), array('class' => 'refresh')); ?> </li>
        <li><?php echo $this->Html->link(__('Edit Menu', true), array('action' => 'edit', $menu['Menu']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('Delete Menu', true), array('action' => 'delete', $menu['Menu']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $menu['Menu']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Menus', true), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Menu', true), array('action' => 'add')); ?> </li>
        <li>
          <?php echo __('Items'); ?>
        </li>
        <li><?php echo $this->Html->link(__('New Menu Item', true), array('controller' => 'menu_items', 'action' => 'add', $menu['Menu']['id']));?> </li>
        <li><?php echo $this->Html->link(__('List Menu Items', true), array('controller' => 'menu_items', 'action' => 'index', $menu['Menu']['id']));?> </li>
      </ul>
    </div>
</div>


<?php echo $this->Html->css('/css/admin/jquery-ui-1.8.13.custom'); ?>
<?php echo $this->Html->script('/js/admin/jquery-ui-1.8.13.custom.min'); ?>
<?php echo $this->Html->script('/menus/js/jquery.ui.nestedSortable'); ?>
<script type="text/javascript">
$(function() {	
	$('.refresh').click(function() {
		location.reload();
		return false;
	});
	
	$('.menu a').click(function() {
		var url = $(this).attr("href");
		var linkText = $(this).text();
		var itemId = $(this).parent().parent().attr("id").replace("list_", "");
		$("#MenuItemId").val(itemId);
		$("#MenuItemItemText").val(linkText);
		$("#MenuItemItemUrl").val(url);
		$("#MenuItemDeleteId").val(itemId);
		return false;
	});
	
	$('.menu').nestedSortable({
		forcePlaceholderSize: true,
		listType: 'ul',
		handle: 'div',
		helper: 'clone',
		opacity: .6,
		items: "li",
		delay: 100,
		tolerance: 'pointer',
		toleranceElement: '> div',
		update: function(event, ui) {
			//$('#loadingimg').show();
		 	var order = $('ul.menu').nestedSortable('toArray');
			$.post('/menus/menu_items/sort.json', {order:order}, 
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