
//onload init
$(function() { 
	// modal dialog windows
	$(".dialog").click(function(e){
		var url = $(this).attr("href");
		$("#siteWrap").append("<div id='dialogLoad' style='background: #fff;'></div>");
		$("#dialogLoad").load(url).dialog({
			modal:true,
			});
		return false;
	});
	
	/* Helper Text show statement */
	if ($.cookie('hideHelperText') == null) {
		$('#helperText').show();
		$('#helpOpen').hide();
	} else {		
		$('#helpOpen').slideDown();
	}
	/* Helper Text links */
	$('#helpClose').click(function(e){
		$.cookie('hideHelperText', 1, { expires: 999 });
		$('#helperText').slideUp('slow');
		$('#helpOpen').show();
	});
	$('#helpOpen').click(function(e){
		$.cookie('hideHelperText', null);
		$('#helperText').slideDown('slow');
		$('#helpOpen').hide();
	});
	
	
	
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
		$('#'+currentName).toggle('slow');
		$('.'+currentName).toggle('slow');
		return false;
	});
	
	$(".toggleHover").hover(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		$('.'+currentName).toggle();
		return false;
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


	// hides form elements except the legend (click the legend to show form elements
  	$('legend.toggleClick').siblings().hide();
	
  	$('legend.toggleClick').click(function(){
    	$(this).siblings().slideToggle("slow");
    });
		
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
	if ($.cookie('fontSize') != null) {
		$('body').css('font-size', $.cookie('fontSize'));
	}
	$('#fontSize1').click(function(e){
		$('body').css('font-size', '0.8em');
		$.cookie('fontSize', '0.8em', { expires: 999 });
	});
	$('#fontSize2').click(function(e){
		$('body').css('font-size', '1.5em');
		$.cookie('fontSize', '1.5em', { expires: 999 });
	});
	$('#fontSize3').click(function(e){
		$('body').css('font-size', '2.2em');
		$.cookie('fontSize', '2.2em', { expires: 999 });
	});
	
});