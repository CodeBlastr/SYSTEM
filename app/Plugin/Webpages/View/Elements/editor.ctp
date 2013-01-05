<?php 
if($this->Session->read('Auth.User.user_role_id') == 1) { 
    $nav = $this->Element('navigation', array(), array('plugin' => 'webpages'));
    echo $this->Html->css('/webpages/css/editor');
	echo $this->Html->script('/js/ckeditor/ckeditor'); ?>
    
    <script type="text/javascript">
        $(function () {
            // init editor
            var content = new Array();
            // this Clear div works good on canopynation, check that if changing
            $('body').append('<div class="#adminNavFloMangrClear" style="clear: both; height: 44px;"></div>').append(<?php echo json_encode($nav); ?>);
            $('.nav-edit').prepend('<li class="nav-edit-button"><a href="#"><i class="icon-edit">Edit menu</i></a></li>');
            $('.nav-edit-button').click(function() {
                window.location = "/webpages/webpage_menus/edit/" + $(this).parent().attr('data-identifier');
            });
            $('#adminNavFloManagr .collapse ul.nav.pull-right').append('<li><div id="edit-mode" class="btn btn-mini" title="Toggle Edit Mode">Edit Mode</div></li><li class="nav-edit save-edit"><div class="btn btn-nav-edit btn-save-edit">Save Edits</div></li><li class="nav-edit cancel-edit"><div class="btn btn-mini btn-nav-edit btn-cancel-edit">Cancel</div></li>');
            $('div[pageid]').each(function(index) {
                var width = $(this).width();
                content[$(this).attr('pageid')] = $(this).html();
                $(this).prepend('<div class="overlay-edit" style="width: ' + width + 'px"> <span class="label">editable</label> </div>');
            });

            // turn on edit mode
            $('#edit-mode').click( function(e) {
            	e.preventDefault();
                $('div[pageid]').each(function(index) {
                    var block = $(this);
                    var pageId = block.attr('pageid');
                    block.attr('contenteditable', 'true');
                    
                    // turn on the editors
                    if (!CKEDITOR.instances['webpage' + pageId]) {
                        var editor = CKEDITOR.inline( document.getElementById( 'webpage' + pageId ));
                        CKEDITOR.on('instanceReady', function(event) {
                            // style the page
                            var color = $('body').css('color');
                            block.css('outline', '1px dashed ' + color);
                            $('div.overlay-edit span.label', block).css('display', 'block');
                            $('#adminNavFloManagr .btn-nav-edit').parent().css('display', 'inline-block');
                        });
                    }
                });
                $('#edit-mode').parent().hide();
            });
            
            // save changes 
            $('.btn-save-edit').click( function() {
                $('div[pageid]').removeAttr('contenteditable').css('outline', 'none');
                $('body').append('<div class="edit-message">test</div>');
                
                $.each(content, function(key, value) {
                    // put if save here
                    $('.overlay-edit').remove();
                    $('br[type="_moz"]').remove();
                    if ($('div[pageid="' + key + '"]').length > 0) {
                        var newContent = $('div[pageid="' + key + '"]').html();
                        content[key] = newContent;
                        $.post('/webpages/webpages/save/' + key, {data : newContent}, function(data) {
                            $('.edit-message').html($.parseJSON(data).msg);
                            $('.edit-message').fadeIn(200).delay(800).fadeOut(500);
                            var width = $('div[pageid="' + key + '"]').width();
                            $('div[pageid="' + key + '"]').prepend('<div class="overlay-edit" style="width: ' + width + 'px"> <span class="label">editable</label> </div>');
                            $('.btn-nav-edit').parent().hide();
                            $('#edit-mode').parent().show();
                            var instance = 'webpage' + key;
                            if (CKEDITOR.instances[instance]) {
                                var editor = CKEDITOR.instances[instance].destroy();
                            }
                        });
                    }
                });
            });
            
            // cancel changes 
            $('.btn-cancel-edit').click( function() {
                $('div[pageid]').removeAttr('contenteditable').css('outline', 'none');
                $.each(content, function(key, value) {
                    var width = $('div[pageid="' + key + '"]').width();
                    $('div[pageid="' + key + '"]').html(value).prepend('<div class="overlay-edit" style="width: ' + width + 'px"> <span class="label">editable</label> </div>');
                    $('.btn-nav-edit').parent().hide();
                    $('#edit-mode').parent().show();
                    var instance = 'webpage' + key;
                    if (CKEDITOR.instances[instance]) {
                        var editor = CKEDITOR.instances[instance].destroy();
                    }
                });
            });
        });
    </script>
<?php
} ?>