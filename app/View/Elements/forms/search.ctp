<?php
/**
 * This search form will search whatever index it is on. 
 * If we are on an index page, it will use that index.
 * If we are not on an index it will use the url variable (default /webpages/webpages/index)
 */
$url = !empty($url) ? $url : '/webpages/webpages/index/';
$inputs = !empty($inputs) ? $inputs : array();
$inputs = Set::merge(array(array('name' => 'contains:name', 'options' => array('class' => 'search-query pull-left', 'label' => false, 'placeholder' => 'Type Your Search and Hit Enter'))), $inputs);
$action = strpos($_SERVER['REQUEST_URI'], 'index') ? $_SERVER['REQUEST_URI'] : $url;
echo $this->Form->create('', array('type' => 'get', 'class' => 'form-inline index-form navbar-form pull-left', 'url' => Router::normalize($action) . '/')); 
foreach ($inputs as $input) {
	echo $this->Form->input($input['name'], $input['options']);
}
echo $this->Form->end(); ?> 
	
<script type="text/javascript">
$(function() {
	$('.index-form').submit(function() {
		var $url = '';
		var $href = $(this).attr("action");
		$('.index-form input[type=text], .index-form select').each(function(index) {
			if (!$(this).val()) {
				$href = $href.replace($(this).attr('name') + ':', '');
			} else if ($href.indexOf($(this).attr('name')) != -1) {
				$pattern = $(this).attr('name') + '([^/]*)';
				$href = $href.replace(new RegExp($pattern, 'g'), $(this).attr('name') + ':' + $(this).val() + '/');
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