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