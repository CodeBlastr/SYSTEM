$(document).ready(function() {
	$('.nav li').click(function() {
		$('li').each(function(index) {
    		$(this).removeClass('active');
		});
		$(this).addClass('active');
	});
	$('.drop .close').click(function() {
		$('.nav li.active').removeClass('active');
		return false;
	});
	$('.post .text .row .expand').click(function() {
		$('.post-reply').slideToggle('slow');
		$('.post .text .row .expand').css('display', 'none');
		$('.post-reply .close').css('display', 'block');
	});
	$('.post-reply .close').click(function() {
		$('.post-reply').slideToggle('slow');
		$('.post .text .row .expand').css('display', 'block');
		$('.post-reply .close').css('display', 'none');
	});
});

