$(function() { 

/**
 * toggling code moved to bootstrap.min.js
 * /
	
	
/**
 * reusable select box update
 * requires json attribute, which is equal to the relative url to call
 * requires element attribute, which is equal to select (other types in other functions)
 * requires rel attribute, which is the target id of the select box to update
 */
	$('select[element="select"]').change(function(){
		var url = '/' + $(this).attr('json') + '/' + $(this).val() + '.json';
		var variable = $(this).attr('variable');
		var target = $(this).attr('rel');
		$.getJSON(url, function(data){
			var items = [];
 			$.each(data[variable], function(key, val) {
				if (val['value']) { value = val['value']; } else { value = val['name']; }
				items += '<option value="' + value + '">' + val['name'] + '</option>';
			});
			$('#' +  target).html(items);
			if ($.isFunction(window.selectCallBack)) { selectCallBack(data); }
	    });
	});

});