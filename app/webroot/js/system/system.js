// JavaScript Document

$().ready(function() {
	// datepicker for date selection
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
	});
	
	$('.datetimepicker').datetimepicker({
		//ampm: true,
		dateFormat: 'yy-mm-dd',
		timeformat: 'hh:mm:ss'
	});
	
	$('.timepicker').timepicker({
		//ampm: true,
		timeformat: 'hh:mm:ss'
	});
	// modal dialog windows
	// needs jquery-ui loaded to work
	$(".dialog").click(function(e){
		var url = $(this).attr("href");
		$("#corewrap").append("<div id='dialogLoad' style='background: #fff;'></div>");
		$("#dialogLoad").load(url).dialog({
			modal:true,
			});
		return false;
	});
	
	
	// hides form elements except the legend (click the legend to show form elements
  	$('legend.toggleClick').siblings().hide();
	
  	$('legend.toggleClick').click(function(){
    	$(this).siblings().slideToggle("slow");
    });
	
	/* site wide toggle, set the click elements class to toggleClick, and the name attribute to the id of the element you want to toggle */
	$(".toggleClick").click(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		$('.'+currentName).toggle();
		$(this).css('cursor', 'pointer');
		return false;
	});
	
	$(".showClick").click(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).show('slow');
		$('.'+currentName).show('slow');
		$(this).css('cursor', 'pointer');
		return false;
	});
	
	$(".toggleHover").hover(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		$(this).css('cursor', 'pointer');
		return false;
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
				if (val['value']) { value = val['value']; } else { val['name']; }
				items += '<option value="' + value + '">' + val['name'] + '</option>';
			});
			$('#' +  target).html(items);
			if ($.isFunction(window.selectCallBack)) { selectCallBack(data); }
	    });
	});
	
	
});
