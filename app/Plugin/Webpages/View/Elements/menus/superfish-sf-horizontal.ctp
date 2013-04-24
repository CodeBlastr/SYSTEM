<?php 

// $data['menu']['WebpageMenu']['type']
// superfish
// superfish sf-horizontal
// superfish sf-vertical
echo $this->Tree->generate($data['items'], array(
    'model' => 'WebpageMenuItem', 
    'alias' => 'item_text', 
	'class' => 'menu '.$data['menu']['WebpageMenu']['type'], 
	'id' => 'menu'.$data['menu']['WebpageMenu']['id'], 
	'element' => 'item', 
	'elementPlugin' => 'webpages'));


// superfish horizontal with horizontal drop downs
if ($data['menu']['WebpageMenu']['type'] == 'superfish sf-horizontal') { 
    echo $this->Html->css('/webpages/menus/css/superfish'); 
	echo $this->Html->css('/webpages/menus/css/superfish-horizontal'); 
	echo $this->Html->script('/webpages/menus/js/jquery.hoverIntent.min'); 
	echo $this->Html->script('/webpages/menus/js/jquery.superfish');
	?>
<script> 
 
    $(document).ready(function(){ 
        $("ul.superfish").superfish({ 
            pathClass:  'current' 
        }); 
    }); 
 
</script>
<?php } ?>