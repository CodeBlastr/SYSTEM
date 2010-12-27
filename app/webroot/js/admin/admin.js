
//tabs with next/prev buttons
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

//tabs with next/prev buttons
$.fn.tabMenu2 = function() {

return this.each(function() {
var $links = $('a', this);
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

}; 
show(current_index);

});
}


//onload init
$(function() { 

/* Getting started tabs */
	$('#contentWrapper div.tabs a').click(function(e){
	$('#contentWrapper div.tabs a').removeClass('active');

	$('#tabTwo, #tabOne').hide();
	
	$(this).addClass('active');

//ie6 png fix
	$('#contentWrapper div.tabs a span.ls,#contentWrapper div.tabs a span.rs').removeAttr('style').ifixpng();
		var id = $(this).attr('rel');
	$('#'+id).show();
	e.preventDefault();
});

/* Technical features tabs */
	$('#technicalFeatures div.tabs').tabMenu2();

/* Getting started recommendations */
	$('#tabTwo').tabMenu();

/* Sidebar closing link */
	$('#sideBar a.close').click(function(e){
		$('#sideBar').hide();
		e.preventDefault();
	});

});

/*IE6 image transpancy issue */
$(document).ready(function(){
	$('img[src$=.png], span.ls, span.rs').ifixpng();
});






// JavaScript Document

/* hide the side bar */
// #col2 h2

$(function() {
	
/* site wide toggle, set the click elements class to toggleClick, and the name attribute to the id of the element you want to toggle */
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
	
	/* When you hover make the dialog a dialog, so that you don't have to redo each one by name, just anything with this class will work */
	$(".toggleClickMenu").hover(function() {
		var currentName = $(this).attr('name');					 
		$('#'+currentName).dialog({
			autoOpen: false,
		});
	});
	/* then when you click show the dialog */
	$(".toggleClickMenu").click(function() {
		var currentName = $(this).attr('name');
		$('#'+currentName).dialog('open');			
		return false;
	});
			
	
	$(".toggleHoverMenu").click(function() {
		$('#'+currentName).dialog('open');			
		return false;
	});
	
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 1000;
	/*$(function() {
		$('#dialog').dialog({
			autoOpen: false,
			show: 'blind',
			hide: 'explode'
		});
		
		$('#opener').click(function() {
			$('#dialog').dialog('open');
			return false;
		});
	});*/

	
	//cookie to adjust side bar visibility
	//hide the side bar
	$("#toggleSidebar").toggle(function () {
		$("#toggleSidebar").text('Show Sidebar').css({right: '1%'});
		  
		$("#col2").hide();
		$("#content").css({right: '0'});
		$("#col1").css({width: '98%', left: '1%'});
		$.cookie("col2hide", "true", { expires: 7 });
	}, function () {
		$("#toggleSidebar").text('Hide Sidebar').css({right: '-24%'});
		$("#col2").show();
		$("#content").css({right: '25%'});
		$("#col1").css({width: '72%', left: '26%'});
		$.cookie("col2hide", "false");	
	});
	// hide the second column if the cookie is set 
	if( $.cookie("col2hide") == 'true' ) {
		$("#toggleSidebar").text('Show Sidebar').css({right: '1%'});
		
		$("#col2").hide();
		$("#content").css({right: '0'});
		$("#col1").css({width: '98%', left: '1%'});
	} else {
		$("#toggleSidebar").text('Hide Sidebar');
	}
	// hide the second column if it doesn't exist
	if($('#col2').length == 0) {
		$("#content").css({right: '0'});
		$("#col1").css({width: '98%', left: '1%'});
	}
	
	// open dialog windows$(document).ready(function() {	
	var $loading = $('<img style="position: absolute; top: 50%; left: 50%;" src="/img/ajax-loader.gif" alt="loading">');

	/*$('.dialog').each(function() {
		var $dialog = $('<div></div>')
			.append($loading.clone());
		var $link = $(this).one('click', function() {
			$dialog
				.load($link.attr('href'))
				.dialog({
					title: $link.attr('title'),
					width: 500,
					height: 300,
					modal: true,
					buttons: {
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});

			$link.click(function() {
				$dialog.dialog('open');

				return false;
			});
			return false;
		});
	});*/

});





/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String name The name of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 * @type undefined
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */

/**
 * Get the value of a cookie with the given name.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String name The name of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

