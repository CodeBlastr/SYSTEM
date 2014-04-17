$(function() {
	$('.map_canvas').each(function(index, Element) {
		var locations = [];
		var content = [];
		var center = false;
		
	    $infotext = $(Element).children('.map-item');
	    
	    $infotext.each(function(key, item) {
	    	locations[key] = [];
	        locations[key]['latitude'] = $(item).children('.latitude').text();
	        locations[key]['longitude'] = $(item).children('.longitude').text();
	        locations[key]['marker_text'] = $(item).children('.marker_text').html();
	    });
	    var infowindow;
	
		// don't use "var map" we need this to be global (see blockshares property view)
	    map = new google.maps.Map(Element, {
			zoom: parseInt($(Element).children('.zoom').text()),
	      	center: new google.maps.LatLng(locations[0].latitude, locations[0].longitude), //This assumes that the best match is first in the locations array
	      	mapTypeId: google.maps.MapTypeId.ROADMAP
	    });
	
	    var infowindow = new google.maps.InfoWindow();
	
	    var marker, i;
	
	    for (i = 0; i < locations.length; i++) {
			marker = new google.maps.Marker({
	        	position: new google.maps.LatLng(locations[i].latitude, locations[i].longitude),
	        	map: map
	      	});
	      	google.maps.event.addListener(marker, 'click', (function(marker, i) {
	        	return function() {
	          		infowindow.setContent(locations[i].marker_text);
	          		infowindow.open(map, marker);
	        	}
	      	})(marker, i));
	   	}
	});
});