
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
		$('.ui-tabs-panel').css('width', '100%');
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


	/* hides form elements except the legend (click the legend to show form elements
  	$('legend').siblings().hide();
	
  	$('legend').click(function(){
    	$(this).siblings().slideToggle("slow");
    });*/
		
	$('#tabs').tabs();	
	$('#navigation').tabs();
	/* make the current tab have the class active
	$('#tabs a').click(function() {
		$('#tabs a').removeClass('active');
		$(this).addClass('active');
	});
	$('#navigation a').click(function() {
		$('#navigation a').removeClass('active');
		$(this).addClass('active');
	});**/
	
	
	/* Font size changer */
	$('#fontSize1').click(function(e){
		$('body').css('font-size', '0.8em');
	});
	$('#fontSize2').click(function(e){
		$('body').css('font-size', '1.5em');
	});
	$('#fontSize3').click(function(e){
		$('body').css('font-size', '2.2em');
	});
	
});