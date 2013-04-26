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

// superfish vertical 
if ($data['menu']['WebpageMenu']['type'] == 'superfish sf-vertical') { 
    echo $this->Html->css('/webpages/menus/css/superfish'); 
	echo $this->Html->css('/webpages/menus/css/superfish-vertical'); 
	echo $this->Html->script('/webpages/menus/js/jquery.hoverIntent.min'); 
	echo $this->Html->script('/webpages/menus/js/jquery.superfish');
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