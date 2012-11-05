<?php
/**
 * This search form will search whatever index it is on. 
 * If we are on an index page, it will use that index.
 * If we are not on an index it will use the url variable (default /webpages/webpages/index)
 */
$url = !empty($url) ? $url : '/webpages/webpages/index/';
$inputs = !empty($inputs) ? $inputs : array(array('name' => 'contains:name', 'options' => array('label' => '', 'placeholder' => 'Type Your Search and Hit Enter')));
$action = strpos($_SERVER['SCRIPT_URL'], 'index') ? $_SERVER['SCRIPT_URL'] : $url;
echo $this->Form->create('', array('type' => 'get', 'class' => 'form-inline index-form', 'url' => Router::normalize($action) . '/')); 
foreach ($inputs as $input) {
	echo $this->Form->input($input['name'], $input['options']);
}
//echo $this->Form->input('filter:contact_type', array('label' => '', 'type' => 'select', 'empty' => '-- All --', 'options' => $contactTypes));
echo $this->Form->end(); ?> 


	
<script type="text/javascript">
$(function() {
	$('.index-form').submit(function() {
		var $url = '';
		var $href = $(this).attr("action");
		$('.index-form input[type=text], .index-form select').each(function(index) {
			//console.log('name : ' + $(this).attr('name'));
			if (!$(this).val()) {
				$href = $href.replace($(this).attr('name') + ':', '');
				//console.log($href);
			} else if ($href.indexOf($(this).attr('name')) != -1) {
				$pattern = $(this).attr('name') + '([^/]*)';
				//console.log('pattern : ' + $pattern);
				$href = $href.replace(new RegExp($pattern, 'g'), $(this).attr('name') + ':' + $(this).val() + '/');
				//console.log('href: ' + $href);
			} else {
				$url = $url + $(this).attr('name') + ':' + $(this).val() + '/';	
			}
		});
		$location = $href + $url;
		$location = $location.replace(new RegExp('//', 'g'), '/'); // normalize the url
		window.location = $location;
		return false;	
	});
});
</script>