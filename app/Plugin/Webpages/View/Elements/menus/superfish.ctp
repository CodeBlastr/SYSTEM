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

// basic superfish horizontal with vertical drop downs
if ($data['menu']['WebpageMenu']['type'] == 'superfish') { 
	echo $this->Html->css('/webpages/menus/css/superfish'); 
	echo $this->Html->script('/webpages/menus/js/jquery.hoverIntent.min'); 
	echo $this->Html->script('/webpages/menus/js/jquery.superfish');
	echo $this->Html->script('/webpages/menus/js/jquery.superSubs'); ?> 
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