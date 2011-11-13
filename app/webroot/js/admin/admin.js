
//onload init
$(function() { 
		   
	// datepicker for date selection
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
	});
	
	$('.datetimepicker').datetimepicker({
		//ampm: true,
		//showSecond: true,
		dateFormat: 'yy-mm-dd',
		stepHour: 1,
		stepMinute: 10,
		stepSecond: 10,
		timeformat: 'hh:mm:ss'
	});
	
	$(".accordion" ).accordion({
			collapsible: true,
			autoHeight: false
	});
	
	
	$('.timepicker').timepicker({
		//ampm: true,
		//showSecond: true,
		stepHour: 1,
		stepMinute: 10,
		stepSecond: 10,
		timeformat: 'hh:mm:ss'
	});
	
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
	if ($.cookie('showHelperText') == null) {
		$('#helpOpen').slideDown();
	} else {		
		$('#helperText').show();
		$('#helpOpen').hide();
	}
	/* Helper Text links */
	$('#helpClose').click(function(e){
		$.cookie('showHelperText', null);
		$('#helperText').slideUp('slow');
		$('#helpOpen').show();
	});
	$('#helpOpen').click(function(e){
		$.cookie('showHelperText', 1, { expires: 999 });
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
				if (val['value']) { value = val['value']; } else { value = val['name']; }
				items += '<option value="' + value + '">' + val['name'] + '</option>';
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
		//$('.'+currentName).toggle('slow');
		return false;
	});
	
	$(".toggleHover").hover(function () {
		var currentName = $(this).attr('name');
		$('#'+currentName).toggle();
		$('.'+currentName).toggle();
		return false;
	});
	
	
	/* Tabs 
	$('#contentWrapper div.tabs a').click(function(e){
		$('#contentWrapper div.tabs a').removeClass('active');
		$('#tabTwo, #tabOne').hide();
	
		$(this).addClass('active');
	
		$('#contentWrapper div.tabs a span.ls,#contentWrapper div.tabs a span.rs').removeAttr('style');
			var id = $(this).attr('rel');
			$('#'+id).show();
			e.preventDefault();
	
	});*/


	// hides form elements except the legend (click the legend to show form elements
  	$('legend.toggleClick').siblings().hide();
	
  	$('legend.toggleClick').click(function(){
    	$(this).siblings().slideToggle("toggle");
    });
	
	
	$("#quickNav .menu").toggle(function() {
		$("#siteSearch").hide();
		$("#siteMenu").slideDown('slow');
	}, function() {
		$("#siteMenu").slideUp('slow');
	});
	$("#quickNav .search").toggle(function() {
		$("#siteMenu").hide();
		$("#siteSearch").slideDown('slow');
	}, function() {
		$("#siteSearch").slideUp('slow');
	});
		
	//$('#tabs').tabs({fx:{height: "toggle"}});	
	//$('.tabs').parent().tabs({fx:{height: "toggle"}});
	/* make the current tab have the class active
	$('#tabs a').click(function() {
		$('#tabs a').removeClass('active');
		$(this).addClass('active');
	});
	$('#navigation a').click(function() {
		$('#navigation a').removeClass('active');
		$(this).addClass('active');
	});**/
	
	
	/* Index pages */ 
	
	$(".collapsed .indexCell .indexCell").hide();
	
	$(".collapsed .indexCell .indexCell:first-child").show();
	
	$(".collapsed .indexCell .indexCell:first-child").click(function (e) {
		$(this).siblings().slideToggle("toggle");
		e.preventDefault();
	});
	
	/* Font size changer */
	if ($.cookie('fontSize') != null) {
		$('body').css('font-size', $.cookie('fontSize'));
	}
	$('#fontSize1').click(function(e){
		$('body').css('font-size', '0.8em');
		$.cookie('fontSize', '0.8em', { expires: 999 });
	});
	$('#fontSize2').click(function(e){
		$('body').css('font-size', '1em');
		$.cookie('fontSize', '1em', { expires: 999 });
	});
	$('#fontSize3').click(function(e){
		$('body').css('font-size', '1.6em');
		$.cookie('fontSize', '1.6em', { expires: 999 });
	});
	
	
	/* Layout Fixes */
	/* Stick Footer 
	positionFooter(); 
	function positionFooter(){
		var padding_top = $("#awesomeFooter").css("padding-top").replace("px", "");
		var page_height = $(document.body).height() - padding_top;
		var window_height = $(window).height();
		var difference = window_height - page_height;
		if (difference < 0) 
			difference = 0;
 
		$("#awesomeFooter").css({
			padding: difference + "px 0 0 0"
		})
	}
 
	$(window)
		.resize(positionFooter)*/
		
	/* Wider than containing box */
	
	
	
	
	/*  Make any select a combox by adding class="combox" 
		http://jqueryui.com/demos/autocomplete/ */
	$.widget( "ui.combobox", {
		_create: function() {
			var self = this,
				select = this.element.hide(),
				selected = select.children( ":selected" ),
				value = selected.val() ? selected.text() : "";
			// get the original name of the input so that we can set it back as needed
			var originalName = select.attr("name");
			var input = this.input = $( "<input>" )
				.insertAfter( select )
				.val( value )
				.autocomplete({
					delay: 0,
					minLength: 0,
					source: function( request, response ) {
						var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
						response( select.children( "option" ).map(function() {
							var text = $( this ).text();
							if ( this.value && ( !request.term || matcher.test(text) ) )
								return {
									label: text.replace(
										new RegExp(
											"(?![^&;]+;)(?!<[^<>]*)(" +
											$.ui.autocomplete.escapeRegex(request.term) +
											")(?![^<>]*>)(?![^&;]+;)", "gi"
										), "<strong>$1</strong>" ),
									value: text,
									option: this
								};
						}) );
					},
					select: function( event, ui ) {
						ui.item.option.selected = true;
						self._trigger( "selected", event, {
							item: ui.item.option
						});
					},
					change: function( event, ui ) {
						$(this).attr("name", "");
						select.attr("name", select.attr("ifmatchname"));
						if ( !ui.item ) {
							var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
								valid = false;
							select.children( "option" ).each(function() {
								if ( $( this ).text().match( matcher ) ) {
									this.selected = valid = true;
									return false;
								}
							});
							if ( !valid ) {
								// remove invalid value, as it didn't match anything
								select.attr("name", "");
								$(this).attr("name", originalName);
								//$( this ).val( "" );
								//$( this ).attr( "type", "text" );
								// select.val( $( this ).val() );
								//input.data( "autocomplete" ).term = "";
								//return false;
							}
						}
					}
				})
				.addClass( "ui-widget ui-widget-content ui-corner-left" );
				input.data( "autocomplete" )._renderItem = function( ul, item ) {
				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<a>" + item.label + "</a>" )
					.appendTo( ul );
			};
			
			this.button = $( "<button type='button'>&nbsp;</button>" )
				.attr( "tabIndex", -1 )
				.attr( "title", "Show All Items" )
				.insertAfter( input )
				.button({
					icons: {
						primary: "ui-icon-triangle-1-s"
					},
					text: false
				})
				.removeClass( "ui-corner-all" )
				.addClass( "ui-corner-right ui-button-icon" )
				.click(function() {
					// close if already visible
					if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
						input.autocomplete( "close" );
						return;
					}
						// work around a bug (likely same cause as #5265)
					$( this ).blur();
						// pass empty string as value to search for, displaying all results
					input.autocomplete( "search", "" );
					input.focus();
				});
		},
		destroy: function() {
			this.input.remove();
			this.button.remove();
			this.element.show();
			$.Widget.prototype.destroy.call( this );
		}
	});
	
	
		
	$( ".combobox" ).combobox();
	$( "#toggle" ).click(function() {
		$( ".combobox" ).toggle();
	});
	var boxWidth = $( ".combobox" ).width();
	var buttonWidth = $( ".combobox" ).parent().find("button").width();
	$( ".combobox" ).parent().css("width", boxWidth + buttonWidth + 30);
	$( ".combobox" ).parent().find("button").css("margin-left", "-5px");
	
	/* End Combox Box */
	
	
	/* Added a slight delay to form submissions in order to allow the change events to be triggered before the submit event when you go directly from an input to a submit button without losing focus on the changed input first.  Contacts Add Person with autocomplete would not work reliably without this, and since the form is so simple we cannot depend on the user first going to another input before hitting submit */
	$("form").submit(function(e) {
		e.preventDefault();
		var self = this;
		window.setTimeout(function() {
			self.submit();
		}, 200);
	});
});