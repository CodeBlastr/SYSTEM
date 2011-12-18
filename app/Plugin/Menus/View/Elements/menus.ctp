<?php 
/** 
 * Menu Element for Display Various Menu Types
 *
 * @todo 	Move the menu types into their own elements or something, because it will get way too hectic in here.
 */
$data = $this->requestAction(array('plugin' => 'menus', 'controller' => 'menus', 'action' => 'element', $id), array('pass' => array($id)));
# $data['menu']['Menu']['type']
# superfish
# superfish sf-horizontal
# superfish sf-vertical
echo $this->Tree->generate($data['items'], array(
			'model' => 'MenuItem', 
			'alias' => 'item_text', 
			'class' => 'menu '.$data['menu']['Menu']['type'], 
			'id' => 'menu'.$data['menu']['Menu']['id'], 
			'element' => 'item', 
			'elementPlugin' => 'menus'));
?>

<?php 
# basic superfish horizontal with vertical drop downs
if ($data['menu']['Menu']['type'] == 'superfish') { 
	echo $this->Html->css('/menus/css/superfish'); 
	echo $this->Html->script('/menus/js/jquery.hoverIntent.min'); 
	echo $this->Html->script('/menus/js/jquery.superfish');
	echo $this->Html->script('/menus/js/jquery.superSubs'); 
?> 
<script> 
 
    $(document).ready(function(){ 
        $("ul.superfish").supersubs({ 
            minWidth:    12,   // minimum width of sub-menus in em units 
            maxWidth:    27,   // maximum width of sub-menus in em units 
            extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
                               // due to slight rounding differences and font-family 
        }).superfish();  // call supersubs first, then superfish, so that subs are 
                         // not display:none when measuring. Call before initialising 
                         // containing tabs for same reason. 
    }); 
 
</script>
<?php } ?>


<?php 
# superfish horizontal with horizontal drop downs
if ($data['menu']['Menu']['type'] == 'superfish sf-horizontal') { 
	echo $this->Html->css('/menus/css/superfish'); 
	echo $this->Html->css('/menus/css/superfish-horizontal'); 
	echo $this->Html->script('/menus/js/jquery.hoverIntent.min'); 
	echo $this->Html->script('/menus/js/jquery.superfish');
	?>
<script> 
 
    $(document).ready(function(){ 
        $("ul.superfish").superfish({ 
            pathClass:  'current' 
        }); 
    }); 
 
</script>
<?php } ?>


<?php 
# superfish vertical 
if ($data['menu']['Menu']['type'] == 'superfish sf-vertical') { 
	echo $this->Html->css('/menus/css/superfish'); 
	echo $this->Html->css('/menus/css/superfish-vertical'); 
	echo $this->Html->script('/menus/js/jquery.hoverIntent.min'); 
	echo $this->Html->script('/menus/js/jquery.superfish');
?>
<script> 
 
    $(document).ready(function(){ 
        $("ul.superfish").superfish({ 
            animation: {height:'show'},   // slide-down effect without fade-in 
            delay:     500               // 1.2 second delay on mouseout 
        }); 
    }); 
 
</script>
<?php } ?>