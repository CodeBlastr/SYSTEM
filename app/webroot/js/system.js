$(function() { 

/**
 * Hides form elements that come after a legend with the class toggleClick
 * <legend class="toggleClick">Legend Text</legend>
 */
  	$('legend.toggleClick').siblings().hide();
	$('legend.toggleClick').addClass("toggle");
	
  	$('legend.toggleClick').click(function(){
    	$(this).siblings().slideToggle("toggle");
		if ($(this).is(".toggle")) {
			$(this).removeClass("toggle");
			$(this).addClass("toggled");
		} else {
			$(this).removeClass("toggled");
			$(this).addClass("toggle");
		}
    });
	
/**
 * site wide toggle, set the click elements class to toggleClick, 
 * and the data-target attribute to the selector of the element you want to toggle. 
 * example:  <div class="toggleClick" data-target="#someId + .someClass">click to toggle</div>
 */
	$(".toggleClick, .toggleHover, .showClick").css('cursor', 'pointer');
	$(".toggleClick, .toggleHover, .showClick").each( function(index) {
		var currentName = $(this).attr("data-target");
		$(currentName).hide();
	});
	
	$(".toggleClick").click(function (e) {
		var currentName = $(this).attr('data-target');
		$(currentName).toggle();
		return false;
	});
	
	$(".toggleHover").hover(function () {
		var currentName = $(this).attr('data-target');
		$(currentName).toggle();
		return false;
	});
	
	$(".showClick").click(function () {
		var currentName = $(this).attr('data-target');
		$(currentName).show('slow');
		return false;
	});
	
	
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