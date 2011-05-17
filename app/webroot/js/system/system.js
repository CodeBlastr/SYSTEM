// JavaScript Document

$().ready(function() {
/* site wide toggle, set the click elements class to toggleClick, and the name attribute to the id of the element you want to toggle */
	$(".toggleClick").click(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		$(this).css('cursor', 'pointer');
		return false;
	});
	
	$(".toggleHover").hover(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		$(this).css('cursor', 'pointer');
		return false;
	});
});