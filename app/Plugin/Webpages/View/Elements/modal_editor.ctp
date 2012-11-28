<?php 
if($this->Session->read('Auth.User.user_role_id') == 1) { 
	echo $this->Html->css('/webpages/css/editor');
	echo $this->Html->script('/js/ckeditor/ckeditor'); ?>
	
	<script type="text/javascript" >

	$(document).ready(function() {
		var slideDockHeight = $('#slidedock').height();
		$('body').css('position', 'relative');
		$('body').css('top', slideDockHeight + 'px');
        $('body').append('<div id="modalMessage">test</div>');
   });
	

	var myStyles = new Array('tmp');
	
	function goEdit(id) {
    
	<?php 
	// taken from ckehelper 
	if (CakeSession::read('Auth.User') && defined('SITE_DIR')) {
		CakeSession::write('KCFINDER.disabled', false);
		CakeSession::write('KCFINDER.uploadURL', '/theme/default/upload/' . CakeSession::read('Auth.User.id'));
		CakeSession::write('KCFINDER.uploadDir', '../../../../' . SITE_DIR . '/View/Themed/Default/webroot/upload/' . CakeSession::read('Auth.User.id'));
    ?>
		if (!destroyCKE()) {
			return false;
		}
        
        if (id.indexOf('nav-') == 0) {
            if ($('#' + id).attr('data-identifier').length > 0) {
                window.location = "/webpages/webpage_menus/edit/" + $('#' + id).attr('data-identifier');
            }
        }

		if ($('#' + id).length < 1) return 'О russian text!';
		//edit_width    = $('#' + id).width();
        //edit_height   = $('#' + id).height() + 100;
		edit_width 		= $("#modalEditorWrap").width();
		edit_height 	= $("#modalEditorWrap").height();
     	var page_id   = $('#' + id).attr('pageid');
     	var page_data = '';
 		$.ajax({
			async: false, 
			type: 'post',
			url: '/webpages/webpages/getRawPage/' + page_id,
			success: function (data, textStatus, XMLHttpRequest) {
				page_data = $.parseJSON(data).page.Webpage.content;
			}
		});
        $(document.body).append('<div id="background_layer" onclick="offEditMode(true);"></div>');
		var editor = CKEDITOR.replace('modalEditor', {
			extraPlugins: 'media', 
			filebrowserBrowseUrl: '/js/kcfinder/browse.php?type=files', 
			filebrowserImageBrowseUrl: '/js/kcfinder/browse.php?type=img',
			filebrowserFlashBrowseUrl: '/js/kcfinder/browse.php?type=flash',
			filebrowserUploadUrl: '/js/kcfinder/upload.php?type=files',
			filebrowserImageUploadUrl: '/js/kcfinder/upload.php?type=img',
			filebrowserFlashUploadUrl: '/js/kcfinder/upload.php?type=flash', 
			width: edit_width, 
			height: edit_height,
			// copied from config with the addition of save, and the subtraction of maximize
			toolbar: [['Source','-','Save','ShowBlocks','Templates'], ['Copy','Paste'], ['Undo','Redo','-','Replace','-','RemoveFormat'], ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],['Bold','Italic','Underline','Strike','-','Subscript','Superscript'], ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'], ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], ['Link','Unlink','Anchor'], ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'], ['Format','Font','FontSize'], ['TextColor','BGColor'], ['Media', 'Video_JS']],
			toolbarCanCollapse: true, 
			startupFocus: true});
		
        editor.setData(page_data);
        // dirty hack for fix ckeditor focus
        if ($.inArray(id, myStyles)) {
            if (!CKEDITOR.env.ie) {$('<style type="text/css"> #cke_' + id + '{ position: fixed; z-index: 997} </style>').appendTo("head");}
            myStyles.push(id);
        }
        editor.on('instanceReady', function (e) {
            $(editor.container.$).addClass('system_editor'); //Add mark for our editors
            $(editor.container.$).find('span [class=cke_toolbox]').addClass('my_cke_toolbox'); // Up toolbox
			$("#modalEditorWrap").center();
			$("#cke_modalEditor").attr("pageid", page_id);
        });
        editor.on( 'dataReady', function( e ) {
            $(document.body).css('padding-top', $('.cke_toolbox').height());
            if (CKEDITOR.env.ie) {$('#cke_' + id).css('position', 'relative'); $('#cke_' + id).css('z-index', '101');}
			$('.cke_button_save').removeClass('cke_disabled');
			$('.cke_button_save').unbind('click'); // Fix double save
			$('.cke_button_save').click(function () {
                saveCKEData();
			});
            $('.cke_button_maximize').click(function () {
                if ($(this).is('.cke_on')) $('.cke_toolbox').css('position', 'static');
                if ($(this).is('.cke_off')) $('.cke_toolbox').css('position', 'fixed');
            });
			editor.resetDirty();
            editor.focus();
		});
		return true;
	<?php 
	} // end the SITE DIR and User Session Check ?>
	}

	function destroyCKE () {
        for (i in CKEDITOR.instances) {
			if (!$(CKEDITOR.instances[i].container.$).hasClass('system_editor')) continue;
            if (CKEDITOR.instances[i].checkDirty()) {
				if (!confirm('Exit without saving?')) {
					return false;
				}
			}
        }
		return true;
	}
	
	
	function editAreasOn () {
		$('#webpage_content').append('<div class="hover_div"></div>');
		$("div[id^='edit_webpage_include']").append('<div class="hover_div"></div>');
        $(".nav-edit").append('<div class="hover_div nav-edit-button"></div>');
        
		
		$(".hover_div").addClass("hover_include");
		$(".hover_div").parent().css({ position : "relative" });
        
        $(".hover_div").css({
			position : "absolute",
			top : "0px",
			left: "0px",
			//width:  "100%",
			//height: "100%",
            cursor: "pointer",
            overflow: "visible"
        });
	}
	
	
	function editAreasOff () {
		$('.hover_div').remove();
	}
	
	function onEditMode () {
		editAreasOn();
		
		$('.hover_div').click( function() {
			goEdit($(this).parent().attr("id"));
			editAreasOff();
		});
		
        $('#edit_button').unbind('click');
		$('#edit_button').click( function() {
			offEditMode(true);
		});
        $('#edit_button').addClass('enabled_edit_button');
        $('#edit_button').removeClass('edit_button');
		$('#edit_button').attr('title', 'Turn Edit Mode Off');
		$('#edit_button span').html('Edit Mode : On');
	}

	function offEditMode(isReload) {
		if (!destroyCKE()) {
			return false;
		}
		editAreasOff();
        $('#webpage_content').unbind('click');
        $('#webpage_content').unbind('mouseover');
        $("div[id^='edit_webpage_include']").unbind('click');
        $("div[id^='edit_webpage_include']").unbind('mouseover');
        $('#edit_button').unbind('click');

		$('#edit_button').click( function() {
			onEditMode();
		});
        $('#edit_button').removeClass('enabled_edit_button');
		$('#edit_button').addClass('edit_button');
		$('#edit_button').attr('title', 'Turn Edit Mode On');
		$('#edit_button span').html('Edit Mode : Off');
		
		// reload the page to show updates
		if (isReload) { 
			location.reload();
		} else {
       		$(document.body).css('padding-top', '0px');
      	  	$('#background_layer').remove();
			return true;
		}
	}

	function saveCKEData() {
        for (i in CKEDITOR.instances) {
			if (i != 'WebpageContent') { // check to make sure we're not on /webpages/edit/X
	            var editor = CKEDITOR.instances[i];
	            var pageid = $("#cke_modalEditor").attr('pageid');
				$.ajax({
		            async: true,
	                type: 'post',
	                data: {pageData: editor.getData()},
	                url: '/webpages/webpages/savePage/' + pageid,
	                success: function (data, textStatus, XMLHttpRequest) {
	    	            $('#modalMessage').html($.parseJSON(data).msg);
                        $('#modalMessage').fadeIn(200).delay(800).fadeOut(500);
					}
				});
	        	editor.resetDirty();
	        }
		}
		return true;
	}


    $(document).ready( function () {
		$('#edit_button').click( function() {
			onEditMode();
		});
		
		$("div[id^='edit_webpage_include']").each(function(index) {
			var width = $(this).parent().width();
			var height = $(this).parent().height();
			$(this).width(width);
			$(this).height(height);
		});
		
		$('.closeEditor').click( function() {
			offEditMode(true);
		});
		
		$floManagrNav = $('.floManagrNav').detach();
		$("body").prepend($floManagrNav);
	});


	CKEDITOR.on('instanceReady', function (evt) {
	    var editor = evt.editor;
		
	    if (CKEDITOR.env.webkit && parseInt(editor.config.width) < 310) {
	        var iframe = document.getElementById('cke_contents_' + editor.name).firstChild;
	        iframe.style.display = 'block';
	    }
	});
	
	jQuery.fn.center = function() {
   		this.css("position","fixed");
		var top = (($(window).height() - this.outerHeight(false)) / 2);
		var left = (($(window).width() - this.outerWidth(false)) / 2) + $(window).scrollLeft();
		if (top < 10) { top = 10; }
		if (left < 10) { left = 10; }
		this.css("top", top + "px");
	    this.css("left", left + "px");
    	return this;
	}
	</script>

	<div id="modalEditorWrap" class="draggable">
		<div class="closeEditor">x</div>
		<div class="handle">..<br />..<br />..<br />..<br />..<br />..<br />..</div>
		<div id="modalEditor"></div>
	</div>
	<?php 
	echo $defaultTemplate['Webpage']['name'] == 'twitter-bootstrap.ctp' ? null : $this->Element('navigation', array(), array('plugin' => 'webpages')); // special case 
} ?>
