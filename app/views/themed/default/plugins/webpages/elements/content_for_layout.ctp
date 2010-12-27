<?php  if($this->Session->read('Auth.User.user_group_id') == 1) { ?>
<style type="text/css" >
    .my_cke_toolbox {
        position: fixed;
        top: 0px;
		left: 20%;
		background-color: #D3D3D3;
		padding-left: 5px;
        padding-top: 5px;
		padding-bottom: 5px;
    }

    .edit_button {
		position: fixed;
		bottom: 0px;
		right: 0px;
        background: #ECEBEB url(/img/edit.png) no-repeat;
        width: 18px;
		height: 18px;
		cursor: pointer;
        z-index: 100;
    }

    #background_layer {
        position: fixed;
        background: #808080;
        opacity: 0.8;
        filter: alpha(opacity=70);
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 99;
    }

    .hover_include{
        background-color: #808080;
        filter: alpha(opacity=70);
        z-index: 98;
        opacity: 0.8;
        position: absolute;
        /*border: 1px solid black;*/
    }

    .enabled_edit_button {
        background-color: #D3D3D3;
    }

</style>
<script type="text/javascript" >
	var myStyles = new Array('tmp');

    /*function fixEditorPosition () {
        if ($(editor.container).length > 0) {
            $(editor.container.$).addClass('system_editor'); //Add mark for our editors
            $(editor.container.$).find('span [class=cke_toolbox]').addClass('my_cke_toolbox'); // Up toolbox
            // Move editor into body
            var editor_left = $(editor.container.$).position().left;
            var editor_top  =  $(editor.container.$).position().top;
            $(editor.container.$).css('position', 'absolute');
            var editor_element = $(editor.container.$).detach();
            $(document.body).append(editor_element);
            editor_element.css({top: editor_top, left: editor_left});
            alert('test1');
        }
        else {
            setTimeout(fixEditorPosition(), 100);
            alert('test2');
        }
    }*/

	//TODO Fix session lose
	function goEdit(id) {
		if (!destroyCKE()) {
			return false;
		}
		if ($('#' + id).length < 1) return 'Оп нежданчик!';
		edit_width    = $('#' + id).width();
        edit_height   = $('#' + id).height();
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
		editor = CKEDITOR.replace(id, {width: edit_width, height: edit_height, toolbarCanCollapse: false, startupFocus: true});
        //timer = setTimeout(fixEditorPosition(), 100);
        editor.setData(page_data);
        //dirty hack for fix ckeditor focus
        if ($.inArray(id, myStyles)) {
	        if (!CKEDITOR.env.ie) {$('<style type="text/css"> #cke_' + id + '{ position: relative; z-index: 101} </style>').appendTo("head");}
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
            $(document.body).append('<div id="hover_div"></div>');
            $('#hover_div').addClass('hover_include');
            $('#hover_div').css({top : $(this).position().top + 'px', left: $(this).position().left + 'px', width:  $(this).width() + 'px', height: $(this).height() + 'px'});
            $('#hover_div').click( function() {
                goEdit(id);
            });
            $('#hover_div').mouseout(function() { $(this).remove()});
        });
        $("div[id^='edit_webpage_include']").mouseover(function () {
            var id = this.id
            $(document.body).append('<div id="hover_div"></div>');
            $('#hover_div').addClass('hover_include');
            $('#hover_div').css({top : $(this).position().top + 'px', left: $(this).position().left + 'px', width:  $(this).width() + 'px', height: $(this).height() + 'px'});
            $('#hover_div').click( function() {
                goEdit(id);
            });
            $('#hover_div').mouseout(function() { $(this).remove()});
        });
        $('#edit_button').unbind('click');
		$('#edit_button').click( function() {
			offEditMode();
		});
        $('#edit_button').addClass('enabled_edit_button');
		$('#edit_button').hover(
            function () { $(this).removeClass('enabled_edit_button');},
            function () { $(this).addClass('enabled_edit_button');}
		);
		$('#edit_button').attr('title', 'Off edit mode');
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
		$('#edit_button').hover(
			function () { $(this).addClass('enabled_edit_button');},
			function () { $(this).removeClass('enabled_edit_button');}
		);
		$('#edit_button').attr('title', 'On edit mode');
	}

	function saveCKEData() {
        for (i in CKEDITOR.instances) {
            var editor = CKEDITOR.instances[i];
            var pageid = $('#' + i).attr('pageid');
            if (isNaN($('#webpage_content').attr('pageid'))) {
                    alert('Error! Not found page id');
                    return false;
            }
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
		$('#edit_button').hover(
			function () { $(this).addClass('enabled_edit_button');},
			function () { $(this).removeClass('enabled_edit_button');}
		);
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
<div class="edit_button" id="edit_button" title="On edit mode"></div>
<?php } ?>
<?php
	echo $html->script('/js/ckeditor/ckeditor', false);
	//echo $form->textarea('Webpage.content', array('class' => $ckeditorClass));
	//echo $cke->load('Webpage.content' , $ckfinderPath);
?>
<?php /* End add by Swarog */ ?>
<?php $this->set('title_for_layout', $webpage['Webpage']['title']); ?>
<?php #echo $html->meta('keywords', $webpage['Webpage']['keywords'], array(), false); ?>
<?php #echo $html->meta('description', $webpage['Webpage']['description'], array(), false); ?>
<?php echo $webpage['Webpage']['content'];  ?>

<div id="post-comments">
	<?php $commentWidget->options(array('allowAnonymousComment' => false));?>
	<?php echo $commentWidget->display();?>
</div>
