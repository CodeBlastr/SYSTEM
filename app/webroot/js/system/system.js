// Jquery Mobile Show Columns by Type 


$(document).bind("pageshow", function( event, ui){

	var updateGrid = function () {
		
		$("[data-filter-list]").each(function(n) {
			$("#" + $(this).attr("data-filter-list")).parent().hide();
			if ($(this).hasClass("ui-btn-active")) {
				$("#" + $(this).attr("data-filter-list")).parent().show();				
			}
		});
		
		
		$(".filterable").addClass(function() {
			var index = new Array("", "solo", "a", "b", "c", "d");
			var boxes = new Array("a", "b", "c", "d", "e");
			var letter = index[$(this).children(":visible").length];
			
			$(".filterable").removeClass("ui-grid-solo ui-grid-a ui-grid-b ui-grid-c ui-grid-d");
			
			$(this).addClass("ui-grid-" + letter);
			
			$.each($(this).children(":visible"), function(i) {
				console.log($(this).attr("class"));
				$(this).removeClass("ui-block-a ui-block-b ui-block-c ui-block-d ui-block-e");
				$(this).addClass("ui-block-" + boxes[i]);
			});
		});
	}
	
	$("[data-filter-list]").click(function(){
		$(this).toggleClass("ui-btn-active");
		updateGrid();
		return false;
		
	});
	
	updateGrid();
});


$(function() { 

	// reusable select box update
	// requires json attribute, which is equal to the relative url to call
	// requires element attribute, which is equal to select (other types in other functions)
	// requires rel attribute, which is the target id of the select box to update
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