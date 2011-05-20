
//onload init
$(function() { 
	
	// reusable select box update
	// requires json attribute, which is equal to the relative url to call
	// requires element attribute, which is equal to select (other types in other functions)
	// requires rel attribute, which is the target id of the select box to update
	$('select[element="select"]').change(function(){
		var url = '/' + $(this).attr('json') + '/' + $(this).val() + '.json';
		var target = $(this).attr('rel');
		$.getJSON(url, function(data){
			var items = [];	
 			$.each(data, function(key, val) {
				items += '<option value="' + val['name'] + '">' + val['name'] + '</option>';
			});
			$('#' +  target).html(items);
			if ($.isFunction(window.selectCallBack)) { selectCallBack(data); }
	    });
	});
	
	
	/* site wide toggle, set the click elements class to toggleClick, 
	   and the name attribute to the id of the element you want to toggle */
	$(".toggleClick").click(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		return false;
	});
	
	$(".toggleHover").hover(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		return false;
	});
	
	
	/* Sidebar closing link */
	$('#sideBar a.close').click(function(e){
		$('#sideBar').hide();
		$('.leftContent').css('width', '100%');
		e.preventDefault();
	});
	
	
	/* Tabs */
	$('#contentWrapper div.tabs a').click(function(e){
		$('#contentWrapper div.tabs a').removeClass('active');
		$('#tabTwo, #tabOne').hide();
	
		$(this).addClass('active');
	
		$('#contentWrapper div.tabs a span.ls,#contentWrapper div.tabs a span.rs').removeAttr('style');
			var id = $(this).attr('rel');
			$('#'+id).show();
			e.preventDefault();
	
	});

	/* Getting started recommendations */
	$('#tabTwo').tabMenu();

});



// Tabs
$.fn.tabMenu = function() {

	return this.each(function() {
		var $links = $('ul.left a', this);
		var $prev = $('ul.right a.prev', this);
		var $next = $('ul.right a.next', this);
		if($links.size()<=0) return false;

		var current = $('a.active', this)[0] || $($links[0]).addClass('active');
		var current_index = $links.index(current);
		var total_links = $links.size()-1;

		$links.each(function(i){
			$(this).data('index',i);
			$(this).click(function(e){
				show($(this).data('index'));
				e.preventDefault();
			});
		});

		function show(index) {
			//hide current
			$('#'+$(current).attr('rel')).hide();
			$(current).removeClass('active');
		
			//show selected
			current = $($links.get(index));
			current_index = index;
			$(current).addClass('active');
			$('#'+$(current).attr('rel')).show();
	
			//next/prev
			if(total_links == index){
				$next.addClass('disabled');
				$prev.removeClass('disabled'); 
			} else if(index == 0){
				$prev.addClass('disabled');
				$next.removeClass('disabled'); 
			} else {
				$prev.removeClass('disabled');
				$next.removeClass('disabled'); 
			} 
		};

		show(current_index);

	});
}
