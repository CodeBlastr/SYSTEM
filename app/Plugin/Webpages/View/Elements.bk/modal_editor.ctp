<?php 
if($this->Session->read('Auth.User.user_role_id') == 1) { 
	echo $this->Html->css('/webpages/css/editor');
	echo $this->Html->script('/js/ckeditor/ckeditor');
?>
<script type="text/javascript" >
	//admin dock panel
	
	$(document).ready(function() {
		var slideDockHeight = $('#slidedock').height();
		$('body').css('position', 'relative');
		$('body').css('top', slideDockHeight + 'px');
   });
	

	var myStyles = new Array('tmp');
	//TODO Fix session lose
	function goEdit(id) {
		if (!destroyCKE()) {
			return false;
		}
		if ($('#' + id).length < 1) return 'Оп нежданчик!';
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
		var editor = CKEDITOR.replace('modalEditor', {extraPlugins: 'media', filebrowserBrowseUrl: '/js/kcfinder/browse.php?type=files&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserImageBrowseUrl: '/js/kcfinder/browse.php?type=images&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserFlashBrowseUrl: '/js/kcfinder/browse.php?type=flash&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserUploadUrl: '/js/kcfinder/upload.php?type=files&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserImageUploadUrl: '/js/kcfinder/upload.php?type=images&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserFlashUploadUrl: '/js/kcfinder/upload.php?type=flash&kcfinderuploadDir=<?php echo SITE_DIR; ?>', width: edit_width, height: edit_height, /*toolbar: [['Save', 'Source', '-', 'Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image', 'Media']],*/ toolbarCanCollapse: true, startupFocus: true});
        // Move editor into body
        /*var editor_left = $(editor.container.$).position().left;
        var editor_top  =  $(editor.container.$).position().top;
        $(editor.container.$).css('position', 'absolute');
        var editor_element = $(editor.container.$).detach();
        $(document.body).append(editor_element);
        editor_element.css({top: editor_top, left: editor_left});*/
        editor.setData(page_data);
        //dirty hack for fix ckeditor focus
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
	}

	function destroyCKE () {
        for (i in CKEDITOR.instances) {
			if (!$(CKEDITOR.instances[i].container.$).hasClass('system_editor')) continue;
            if (CKEDITOR.instances[i].checkDirty()) {
				if (!confirm('Exit without saving?')) {
					return false;
				}
			}
         	/*	renders the page (but isn't needed if you reload
			var page_id   = $('#' + i).attr('pageid');
     		$.ajax({
    			async: false, 
    			type: 'post',  
    			url: '/webpages/webpages/getRenderPage/' + page_id,
    			success: function (data, textStatus, XMLHttpRequest) {
    				page_data = $.parseJSON(data).page.Webpage.content;
    			}
    		});*/
            //CKEDITOR.instances[i].destroy();
            //$('#' + i).html(page_data);
        }
		return true;
	}
	
	
	function editAreasOn () {
		$("div[id^='edit_webpage_include']").css({
				width : $(this).find("div:first-child").width + "px",
		});
		
		$('#webpage_content').append('<div class="hover_div"></div>');
		$("div[id^='edit_webpage_include']").append('<div class="hover_div"></div>');
		
		
		$(".hover_div").addClass("hover_include");
		$(".hover_div").parent().css({ position : "relative", });
       
	    $(".hover_div").css({
				position : "absolute",
				top : "0px",
				left: "0px",
				width:  "99%",
				height: "99%"
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
            var editor = CKEDITOR.instances[i];
			//var pageid = $('#' + i).attr('pageid');
            var pageid = $("#cke_modalEditor").attr('pageid');
            /* Commented out on 6/9/2011  Delete if its a month later and its still commented out.
			if (isNaN($('#webpage_content').attr('pageid'))) {
                    alert('Error! Page Id Not Found');
                    return false;
            }*/
            $.ajax({
                    async: true,
                    type: 'post',
                    data: {pageData: editor.getData()},
                    url: '/webpages/webpages/savePage/' + pageid,
                    success: function (data, textStatus, XMLHttpRequest) {
                        alert($.parseJSON(data).msg);
                    }
                });
                editor.resetDirty();
        }
		return true;
	}

    $(document).ready( function () {
		$('#edit_button').click( function() {
			onEditMode();
		});
		
		$("div[id^='edit_webpage_include']").each(function(index) {
			var width = $("div", this).first().width();
			var height = $("div", this).first().height();
			$(this).width(width);
			$(this).height(height);
		});
		
		$('.closeEditor').click( function() {
			offEditMode(true);
		});
	});

	CKEDITOR.on('instanceReady', function (evt) {
	    //editor
	    var editor = evt.editor;

	    //webkit not redraw iframe correctly when editor's width is < 310px (300px iframe + 10px paddings)
	    if (CKEDITOR.env.webkit && parseInt(editor.config.width) < 310) {
	        var iframe = document.getElementById('cke_contents_' + editor.name).firstChild;
	       // iframe.style.display = 'none';
	        iframe.style.display = 'block';
	    }
	});
	
	jQuery.fn.center = function() {
   		this.css("position","fixed");
		var top = (($(window).height() - this.outerHeight()) / 2);
		var left = (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft();
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
<?php echo $this->Element('navigation', array('plugin' => 'webpages')); ?>
<?php } ?>
