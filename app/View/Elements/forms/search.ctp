<?php
/**
 * This search form will search whatever index it is on. 
 * If we are on an index page, it will use that index.
 * If we are not on an index it will use the url variable (default /webpages/webpages/index)
 */
$formsSearch = !empty($forms_search) ? $forms_search : $formsSearch; // deprecated var name 2013-08-31 RK

if (!empty($formsSearch)) {
	extract($formsSearch);
	$url = !empty($url) ? $url : '/webpages/webpages/index/';
	$inputs = !empty($inputs) ? $inputs : array();
	$inputs = Set::merge(array(array('name' => 'contains:name', 'options' => array('class' => 'search-query pull-left', 'label' => false, 'placeholder' => 'Type Your Search and Hit Enter'))), $inputs);
	$action = strpos($_SERVER['REQUEST_URI'], 'index') ? $_SERVER['REQUEST_URI'] : $url;
	$formOptions['class'] = !empty($formOptions['class']) ? $formOptions['class'] : 'form-inline index-form navbar-form';
	$formOptions['url'] = !empty($formOptions['url']) ? $formOptions['url'] : Router::normalize($action)  . '/';
	$formOptions['type'] = !empty($formOptions['type']) ? $formOptions['type'] : 'get';
	$formOptions['id'] = !empty($formOptions['id']) ? $formOptions['id'] : 'form' . rand(5500, 89000);
	
	echo $this->Form->create('', $formOptions);
	foreach ($inputs as $input) {
		echo $this->Form->input($input['name'], $input['options']);
	}
	echo $this->Form->end(); ?> 
		
	<script type="text/javascript">
		$(function() {
			$('#<?php echo $formOptions['id']; ?>').submit(function() {
				$(this).submitSearch();
				return false;
			});
			
		});
		
		// a little mini jquery function
		(function( $ ){
	   		$.fn.submitSearch = function() {
				var $url = '';
				var $href = this.attr("action");
				var $id = this.attr("id");
				$('#' + $id + ' input[type=text], #' + $id + ' select').each(function(index) {
					if (!$(this).val()) {
						$href = $href.replace($(this).attr('name') + ':', '');
					} else if ($href.indexOf($(this).attr('name')) != -1) {
						$pattern = $(this).attr('name') + '([^/]*)';
						$href = $href.replace(new RegExp($pattern, 'g'), $(this).attr('name') + ':' + $(this).val() + '/');
					} else {
						$url = $url + $(this).attr('name') + ':' + $(this).val() + '/';	
					}
				});
				$location = $href + '/' + $url;
				$location = $location.replace(new RegExp('//', 'g'), '/'); // normalize the url
				window.location = $location;
				return false;
	   		}; 
		})( jQuery );
	</script>
<?php
} 