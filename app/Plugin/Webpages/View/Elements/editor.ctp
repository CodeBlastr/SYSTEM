<?php 
if($this->Session->read('Auth.User.user_role_id') == 1) {
    // this Clear div works good on canopynation, check that if changing 
   	echo '<div class="#adminNavFloMangrClear" style="clear: both; height: 44px;"></div> ' . $this->Element('navigation', array(), array('plugin' => 'webpages'));
    echo $this->Html->css('/webpages/css/editor');
    echo $this->Html->script('/js/ckeditor/ckeditor'); ?>
    
    <script type="text/javascript">
        $(function () {
            // init editor
            var content = new Array();
            var oContent = new Array(); // original html
            // find a better way to put this menu edit button in
            //$('.nav-edit').prepend('<li class="nav-edit-button"><a href="#"><i class="icon-edit"></i></a></li>');
            //$('.nav-edit-button').click(function() {
            //    window.location = "/webpages/webpage_menus/edit/" + $(this).parent().attr('data-identifier');
            //});
            $('#adminNavFloManagr .collapse ul.nav:first-child').append('<li class="edit-mode" style="display: none;"><div id="edit-mode" title="Toggle Edit Mode">Inline Editor</div></li><li class="nav-edit save-edit"><div class="btn btn-nav-edit btn-save-edit">Save Edits</div></li><li class="nav-edit cancel-edit"><div class="btn btn-mini btn-nav-edit btn-cancel-edit">Cancel</div></li>');
            $('div[pageid]').each(function(index) {
                var width = $(this).width();
                content[$(this).attr('pageid')] = $(this).html();
            });

            // turn on edit mode
            $('#edit-mode').click( function(e) {
                e.preventDefault();
                $('body').css('cursor', 'wait');
                var color = $('body').css('color');
                $('div[pageid]').each(function(index) {
                    var block = $(this);
                    var pageId = block.attr('pageid');
                    block.attr('contenteditable', 'true');
                    
                    // turn on the editors
                    // if (!CKEDITOR.instances['webpage' + pageId]) {
                    if (!CKEDITOR.instances['webpage' + pageId]) {
                        var editor = CKEDITOR.inline(document.getElementById( 'webpage' + pageId ));                        
                        editor.on('instanceReady', function(event) {
                            // style the page
                            $.getJSON('/webpages/webpages/view/' + pageId + '.json', function(data) {
    	                    	oContent[pageId] = data['page'];
		                  	    $('#webpage'  + pageId).html(data['page']);
				                block.addClass('edit-box-active').css('outline', '1px dashed ' + color);
				                $('div.overlay-edit span.label', block).css('display', 'block');
				                $('#adminNavFloManagr .btn-nav-edit').parent().css('display', 'inline-block');
				                $('#toggleMode').attr('disabled', 'disabled').parent().css({cursor: 'not-allowed', opacity: '0.2'}).children('a').css('cursor', 'not-allowed');
				                $('#edit-mode').parent().hide();
				                $('body').css('cursor', 'auto');
		                    });
                        });
                    }
                });
            });
            
            // save changes 
            $('.btn-save-edit').click( function() {
            	var lastKey = content.length - 1;
                $('body').css('cursor', 'wait');
                $('div[pageid]').removeAttr('contenteditable').removeClass('edit-box-active').css('outline', 'none');
                $('body').append('<div class="edit-message">Saving...</div>');
                
                $.each(content, function(key, value) {
                	var editor = CKEDITOR.instances['webpage' + key];
	                
                    $('.overlay-edit').remove();
                    $('br[type="_moz"]').remove();
                	
                    if ($('div[pageid="' + key + '"]').length > 0) {
	                	newContent = CKEDITOR.instances['webpage' + key].getData();
	                	if (oContent[key] == newContent) {
                            // not saving (no change)
	                		$('.edit-message').html('Page ' + key + ' Unchanged');
	                		$('div[pageid ="' + key + '"]').html(content[key]);
	                	} else {
                            // saving
	                        $.post('/webpages/webpages/save/' + key, {data : newContent}, function(data) {
	                            $('.edit-message').html($.parseJSON(data).msg);
	                            $('.edit-message:hidden').fadeIn(200).delay(800).fadeOut(200);
	                            var width = $('div[pageid="' + key + '"]').width();
	                            $('.btn-nav-edit').parent().hide();
	                            $('#edit-mode').parent().show();
	                            $('#toggleMode').removeAttr('disabled').parent().css({cursor: 'auto', opacity: '1'}).children('a').css('cursor', 'auto');
			                   	if (key == lastKey) {
			                    	$('.edit-message').stop().fadeOut(200);
			                	}
	                        });
	                	}

                        if (CKEDITOR.instances['webpage' + key]) {
                        	// this throws an error about a being null, 
                        	// but it seems to be because ckeditor doesn't check for it being null. 
                        	// will have to ignore for now, as it doesn't break anything 3/21/2013 RK
                            var editor = CKEDITOR.instances['webpage' + key].destroy();
                        }
	                   	if (key == lastKey) {
	                    	$('body').css('cursor', 'auto');
	                	}
	                }
                });
            });
            
            // cancel changes 
            $('.btn-cancel-edit').click( function() {
                $('div[pageid]').removeAttr('contenteditable').removeClass('edit-box-active').css('outline', 'none');
                $.each(content, function(key, value) {
                    var width = $('div[pageid="' + key + '"]').width();
                    $('div[pageid="' + key + '"]').html(value);
                    $('.btn-nav-edit').parent().hide();
                    $('#edit-mode').parent().show();
                    $('#toggleMode').removeAttr('disabled').parent().css({cursor: 'auto', opacity: '1'}).children('a').css('cursor', 'auto');
                    if (CKEDITOR.instances['webpage' + key]) {
                        var editor = CKEDITOR.instances['webpage' + key].destroy();
                    }
                });
            });
            
            // deal with the selecting of a box and removing the class which shows the icon
            CKEDITOR.on('currentInstance', function() {
            	if(CKEDITOR.currentInstance != null) {
            		$('#' + CKEDITOR.currentInstance.name).removeClass('edit-box-active');
            	} else {
            		$('.edit-box').addClass('edit-box-active');
            	}
            })
        });
    </script>
<?php
} ?>