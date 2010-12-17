var productCompareOverlay = {
overlay: null,
window: null,
w: null,
pages: new Array(),
current: 0,
initialized: false,

init: function(){
this.overlay = $('#modalOverlay');
this.overlay.click(function(){ productCompareOverlay.hide(); });
this.w = $($('html').get(0));
this.window = $('#modalPhoneCompare');
this.initialized = true; 

$('a.page',this.window).each(function(i){
productCompareOverlay.pages.push($(this));
});
},
show: function(){
if(!this.initialized)
this.init();

this.current = 0;

/* overlay */
this.setOverlaySize();
$(this.overlay).css({ opacity: 0 }).show(); 
$(this.overlay).animate( { opacity: 0.7 }, 200 ); 
$(window).resize(productCompareOverlay.setOverlaySize);

/* window */
var scrollPosition = $(window).scrollTop()+146;
this.window.css({'top':scrollPosition+'px'});
this.window.show();

},
hide: function(){ 
productCompareOverlay.window.hide();
productCompareOverlay.overlay.fadeOut();
$(window).unbind('resize', productCompareOverlay.setOverlaySize);  
},
setOverlaySize: function(){ 
var widthHeight = productCompareOverlay.viewport(); 
$(productCompareOverlay.overlay).css({width:widthHeight[0],height:widthHeight[1]});
},
viewport: function() {

// the horror case
if ($.browser.msie) {

// if there are no scrollbars then use window.height
var d = $(document).height(), w = $(window).height();

return [
window.innerWidth ||  // ie7+
document.documentElement.clientWidth ||  // ie6  
document.body.clientWidth,  // ie6 quirks mode
d - w < 20 ? w : d
];
} 

// other well behaving browsers
return [$(window).width(), $(document).height()];

} 
}

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
$prev.click(showPrev);
$next.click(showNext);

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

function showNext(e){
if(current_index<total_links){
show(current_index+1); 
}
e.preventDefault();
}
function showPrev(e){
if(current_index>0){
show(current_index-1); 
}
e.preventDefault();
}

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

//ie6 png fix
/*
$('span.ls,span.rs',$(current)).removeClass('fix').addClass('fix');
$('span.ls,span.rs',$(current)).removeAttr('style').ifixpng();
*/

//show selected
current = $($links.get(index));
current_index = index;
$(current).addClass('active');

//ie6 png fix
/*
$('span.ls,span.rs',$(current)).removeClass('fix').addClass('fix');
$('span.ls,span.rs',$(current)).removeAttr('style').ifixpng();
*/
$('#'+$(current).attr('rel')).show(); 

}; 
show(current_index);

});
}

var skypeShop = {
initTooltips: function(){
/* tooltips */
$('.tooltipOut').mouseenter(function(){
var offset = $(this).offset();
var left = offset.left + ($(this).width()/2) - 40;
var top = offset.top - $('#toolTip').height()-2;

$('#toolTip').css({'left': left+'px','top': (top-8)+'px','display':'block'}); //'opacity':0
$('#toolTip').stop().animate({'top':top+'px'}); //'opacity':1,

}).mouseleave(function(){
var offset = $('#toolTip').offset();
var top = offset.top-2;
$('#toolTip').stop().animate({'top':top+'px'},100,function(){ $(this).hide(); }); 
//'opacity':0,
//$('#toolTip').fadeOut();
}); 
}
};

//onload init
$(function() { 

/* Getting started tabs */
$('#contentWrapper div.tabs a').click(function(e){
$('#contentWrapper div.tabs a').removeClass('active');

//ie6 png fix
/*$('#contentWrapper div.tabs a span').removeClass('fix');
$('#contentWrapper div.tabs a span.ls').addClass('fix');
$('#contentWrapper div.tabs a span.rs').addClass('fix');*/

$('#startRecommendation, #startCompare').hide();

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
$('#startRecommendation').tabMenu();

/* compare chart click */
$('#compareChart .compareChartContent a').click(function(e){
$('#notSelected').hide();
$('#compareBubbleAlert div.active').hide();
$('#'+$(this).attr('rel')).addClass('active').show();

var position = $(this).position();
var top = (position.top-153);
if(top<45){
var arrowTop = 208-(45-top);
top=45;
$('#compareBubbleArrow').css('top',arrowTop+'px');
}
if(top>222){
var arrowTop = 208+(top-257);
top=257;
$('#compareBubbleArrow').css('top',arrowTop+'px');
}
if(top>45 && top<257){
   $('#compareBubbleArrow').css('top','208px');
}
$('#compareBubbleAlert').css('margin-top',top+'px');

$('#compareChart .compareChartContent a').removeClass('home-active').removeClass('any-active').removeClass('work-active').removeClass('work2-active');
var className = $(this).attr('class');
$(this).addClass(className + '-active');
$('#compareBubbleAlert').show();
e.preventDefault();
});
$('#compareBubbleAlert a.close').click(function(e){
$('#compareBubbleAlert').hide();
e.preventDefault();
});

/* product compare overlay */
$('.showProductCompareOverlay').click(function(e){
productCompareOverlay.show();
e.preventDefault();
});
$('#modalPhoneCompare span.closeButton a').click(function(e){
productCompareOverlay.hide();
e.preventDefault();
});

/* product page gallery */
$('.showPhotosOverlay').click(function(e){
$('#photosOverlay').show();
$('#' + $(this).attr('rel')).click(); 
e.preventDefault();
});
$('#photosOverlay .closeButton').click(function(e){
$('#photosOverlay').hide();
e.preventDefault();
});
$('#photosOverlay div.thumbnails a').each(function(i){
$(this).data('largeImage',$(this).attr('href'));
$(this).attr('href','#img'+i);
});
$('#photosOverlay div.thumbnails a').click(function(e){
$('#photosOverlay div.thumbnails a').removeClass('active');
$(this).addClass('active'); 

$('#photosOverlay #photoName').html($(this).attr('title'));
$('#photosOverlay #photoName').removeClass('dark');
$('#imageLoading').show();

// Image preload process
var that = this;
var objImagePreloader = new Image();
objImagePreloader.onload = function() {

if($(that).hasClass('dark')){
$('#photosOverlay #photoName').addClass('dark'); 
} else {
$('#photosOverlay #photoName').removeClass('dark'); 
}
$('#photosOverlay #currentPhoto').attr('src',$(that).data('largeImage'));
$('#imageLoading').fadeOut();

objImagePreloader.onload=function(){};
};
objImagePreloader.src = $(this).data('largeImage');
e.preventDefault();
});

/* was This Review Helpful */
$('#wasThisReviewHelpful a').each(function(i){
   
var ajaxurl = $(this).attr('href').replace(/^\#/,'');
$(this).attr('href','#h'+i);

$(this).click(function(){
$.ajax({
url: ajaxurl,
cache: false
});

$('#wasThisReviewHelpful').hide();
$('#wasThisReviewHelpfulThanks').show();

}); 
});

/* Mobile software sms form */
var default_mobile_copy = false;
$("#sendSmsBlock #send_to_number").click(function(){
if(!default_mobile_copy) {
default_mobile_copy = $(this).val();
}
$(this).val("");
});
$("#sendSmsBlock #send_to_number").blur(function(){
if($(this).val()==""){
$(this).val(default_mobile_copy);
}
});
$("#sendSmsBlock #send_to_number").keyup(function(){
if($(this).val()==""){
$('#sendSmsButton span').addClass('disabled');
} else {
$('#sendSmsButton span').removeClass('disabled'); 
}
});
if($("#sendSmsBlock #send_to_number").val()==default_mobile_copy){
$('#sendSmsButton span').addClass('disabled');
}

/* Google search box form */
var default_search_copy = false;
$("#searchSet #google-input").click(function(){
if(!default_search_copy) {
default_search_copy = $(this).val();
}
$(this).val("");
});
$("#searchSet #google-input").blur(function(){
if($(this).val()==""){
$(this).val(default_search_copy);
}
});
});

/*IE6 image transpancy issue */
$(document).ready(function(){
$('img[src$=.png], span.ls, span.rs').ifixpng();
});

/* Footer dropdown */
$(document).ready(function() {
var selCountry;
var selTestPath = "http://shop.skype.com/"
$("select[name=userLanguage]").change(function(){
selCountry = $(this).val();
switch(selCountry) {
case "en-us": selCountry = "/";
break;
//case 'ja': selCountry = "https://skype-jp.instoreshop.com/";
//break;
default: selCountry = "/intl/" + selCountry + "/";
}
window.location = selCountry;
});
});