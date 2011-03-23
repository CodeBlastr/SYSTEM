function setTZCountDown(time_inseconds)
{
return time_inseconds;
}
function displayTZCountDown(countdown,tzcd) 
{
//alert(countdown);
//alert(tzcd);
//alert('tzcd');
//alert(todate_extra);
if (countdown < 0) document.getElementById(tzcd).innerHTML = "Deal is no longer available.";
//if (countdown < 0) document.getElementById(tzcd).innerHTML = "Sorry, Deal is over.";
//if (todate_extra < 0) document.getElementById(tzcd).innerHTML = "Sorry, you are too late.";
else {var secs = countdown % 60; 
if (secs < 10) secs = '0'+secs;
var countdown1 = (countdown - secs) / 60;
var mins = countdown1 % 60;
if (mins < 10) mins = '0'+mins;
countdown1 = (countdown1 - mins) / 60;
var hours = countdown1 % 24;
var days = (countdown1 - hours) / 24;
//alert(extradifference);
if(days > 1){
//str	=	days + '<?=("Day")?>' + (days == 1 ? '' : '') + '<br>' +hours+ '<?=("h:")?>' +mins+ '<?=("m:")?>'+secs+'<?=("s")?>';
str	=	days + 'Days' + (days == 1 ? '' : '') + '<br>' +hours+ 'h:' +mins+ 'm:'+secs+'s';
}else if(days == 1){
str	=	days + 'Day' + (days == 1 ? '' : '') + '<br>' +hours+ 'h:' +mins+ 'm:'+secs+'s';
}else{
	str	=	hours+ 'h:' +mins+ 'm:'+secs+'s';
}


//document.getElementById(tzcd).innerHTML = days + " Day" + (days == 1 ? '' : 's') + '<br>' +hours+ 'h:' +mins+ 'm:'+secs+'s';
//alert(str);
document.getElementById(tzcd).innerHTML = str;
setTimeout('displayTZCountDown('+(countdown-1)+',\''+tzcd+'\');',999);
}
}

