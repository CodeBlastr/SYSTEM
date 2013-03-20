<?php 
if($this->Session->read('Auth.User.user_role_id') == 1) { 
	echo $this->Html->css('/webpages/css/editor');
	echo $this->Html->script('/js/ckeditor/ckeditor');
	echo $this->Html->script('/js/jquery.easing.1.3'); ?>
    
<script type="text/javascript">
	//admin dock panel
	$(document).ready(function() {
	var top = '-' + ($('#slidedock').height() - 25);
	var easing = 'easeOutBounce';
	
	$('#slidedock_promo').toggle(
		function() {
			$('#slidedock').animate({'bottom' : 0}, {queue:false, duration:1000, easing: easing});
		}, 
		function() {
			$('#slidedock').animate({'bottom' : top}, {queue:false, duration:500, easing: easing});
		});
	    $('#slidedock').animate({'bottom' : top}, {queue:false, duration:500, easing: easing});
    });

	var myStyles = new Array('tmp');
	//TODO Fix session lose
	function goEdit(id) {
		if (!destroyCKE()) {
			return false;
		}
		if ($('#' + id).length < 1) return 'Оп нежданчик!';
		edit_width    = $('#' + id).width();
        edit_height   = $('#' + id).height() + 100;
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
        $(document.body).append('<div id="background_layer" onclick="destroyCKE();"></div>');
		var editor = CKEDITOR.replace(id, {extraPlugins: 'media', filebrowserBrowseUrl: '/js/kcfinder/browse.php?type=files&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserImageBrowseUrl: '/js/kcfinder/browse.php?type=images&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserFlashBrowseUrl: '/js/kcfinder/browse.php?type=flash&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserUploadUrl: '/js/kcfinder/upload.php?type=files&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserImageUploadUrl: '/js/kcfinder/upload.php?type=images&kcfinderuploadDir=<?php echo SITE_DIR; ?>', filebrowserFlashUploadUrl: '/js/kcfinder/upload.php?type=flash&kcfinderuploadDir=<?php echo SITE_DIR; ?>', width: edit_width, height: edit_height, /*toolbar: [['Save', 'Source', '-', 'Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image', 'Media']],*/ toolbarCanCollapse: true, startupFocus: true});
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
	        if (!CKEDITOR.env.ie) {$('<style type="text/css"> #cke_' + id + '{ position: relative; z-index: 997} </style>').appendTo("head");}
	        myStyles.push(id);
        }

        editor.on('instanceReady', function (e) {
            $(editor.container.$).addClass('system_editor'); //Add mark for our editors
            $(editor.container.$).find('span [class=cke_toolbox]').addClass('my_cke_toolbox'); // Up toolbox
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
         	var page_id   = $('#' + i).attr('pageid');
     		$.ajax({
    			async: false, 
    			type: 'post',  
    			url: '/webpages/webpages/getRenderPage/' + page_id,
    			success: function (data, textStatus, XMLHttpRequest) {
    				page_data = $.parseJSON(data).page.Webpage.content;
    			}
    		});
            CKEDITOR.instances[i].destroy();
            $('#' + i).html(page_data);
        }
        $(document.body).css('padding-top', '0px');
        $('#background_layer').remove();
        return true;
	}
	
	function onEditMode () {
        $('#webpage_content').mouseover(function () {
            var id = this.id
            $(document.body).append('<div class="hover_div"></div>');
            $('.hover_div').addClass('hover_include');
            $('.hover_div').css({top : $(this).offset().top + 'px', left: $(this).offset().left + 'px', width:  $(this).width() + 'px', height: $(this).height() + 'px'});
            $('.hover_div').click( function() {
                goEdit(id);
            });
            $('.hover_div').mouseout(function() { $('.hover_div').remove()});
        });
        $("div[id^='edit_webpage_include']").mouseover(function () {
           var id = this.id
           $(document.body).append('<div class="hover_div"></div>');
           $('.hover_div').addClass('hover_include');
           $('.hover_div').css({top : $(this).offset().top + 'px', left: $(this).offset().left + 'px', width:  $(this).width() + 'px', height: $(this).height() + 'px'});
           $('.hover_div').click( function() {
               goEdit(id);
           });
           $('.hover_div').mouseout(function() { $('.hover_div').remove()});
        });
        $('#edit_button').unbind('click');
		$('#edit_button').click( function() {
			offEditMode();
		});
        $('#edit_button').addClass('enabled_edit_button');
        $('#edit_button').removeClass('edit_button');
		$('#edit_button').attr('title', 'Edit Mode On');
		$('#edit_button').html('<p>Edit Mode : On</p>');
	}

	function offEditMode() {
		if (!destroyCKE()) {
			return false;
		}
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
		$('#edit_button').attr('title', 'On edit mode');
		$('#edit_button').html('<p>Edit Mode : Off</p>');
	}

	function saveCKEData() {
        for (i in CKEDITOR.instances) {
            var editor = CKEDITOR.instances[i];
            var pageid = $('#' + i).attr('pageid');
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
        $("div[id^='edit_webpage_include']").css('min-width', '10px');
        $("div[id^='edit_webpage_include']").css('min-height', '20px');
	});

	CKEDITOR.on('instanceReady', function (evt) {
	    //editor
	    var editor = evt.editor;

	    //webkit not redraw iframe correctly when editor's width is < 310px (300px iframe + 10px paddings)
	    if (CKEDITOR.env.webkit && parseInt(editor.config.width) < 310) {
	        var iframe = document.getElementById('cke_contents_' + editor.name).firstChild;
	        iframe.style.display = 'none';
	        iframe.style.display = 'block';
	    }
	});
</script>

<div id="slidedock"> 
	<div id="slidedock_content">
 	    <div class="dock_btn edit_button" id="edit_button" title="On edit mode"><p>Edit Mode : Off</p></div>
 	    <a href="/webpages/webpage_csses"><div class="dock_btn" id="btn_css" title="Edit Css"><p>Edit CSS</p></div></a>
 	    <a href="/webpages/webpage_jses"><div class="dock_btn" id="btn_css" title="Edit Js"><p>Edit Js</p></div></a>
 	    <a href="/webpages/webpages/index/type:template"><div class="dock_btn" id="btn_templates" title="Edit Template"><p>Edit Templates</p></div></a>
        <?php if (!empty($defaultTemplate['Menu'])) { foreach ($defaultTemplate['Menu'] as $menu) { ?>
 	    <a class="dialog" href="/menus/menu_items/add/<?php echo $menu['id']; ?>/<?php echo !empty($title_for_layout) ? urlencode($title_for_layout) : Inflector::humanize($this->request->params['action'].' '.$this->request->params['controller']); ?>/<?php echo base64_encode($_SERVER['REQUEST_URI']); ?>"><div class="dock_btn" id="btn_templates" title="Add to Menu"><p>Add to <?php echo $menu['name']; ?></p></div></a>
        <?php } } ?>
	</div>
</div>

<?php } ?>