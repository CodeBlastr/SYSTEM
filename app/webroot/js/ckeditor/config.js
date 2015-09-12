CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'oembed,sharelink,confighelper,panel,floatpanel,panelbutton,colorbutton,justify,pagebreak,font';
    //config.extraPlugins = 'mediaembed,oembed,sharelink,confighelper,colorbutton,panelbutton,justify,pagebreak,font';

    config.toolbar = [
        {
            name: 'default', 
            items: ['Bold','Italic','-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList']
        },
        {
            name: 'default2',
            items: ['Image','Link','Unlink','oembed']
            //items: ['Image','Link','Unlink','MediaEmbed']
        },
            '/',
        {
            name: 'extras', 
            items: ['TextColor', 'Underline','Strike','Subscript','Superscript'] 
        },
        {
            name: 'extras2', 
            items: ['Outdent','Indent','Blockquote'] 
        },
        {
            name: 'extras3', 
            items: ['Table','HorizontalRule','PageBreak', 'RemoveFormat']
        },
        {
            name: 'extras4', 
            items: ['Format','Font','FontSize','TextColor']
        }
	  ];
	config.skin = 'moono';

	// temporary while transition to FileStorage is completed
	if (window.location.host == 'www.moderncents.com' || window.location.host == 'www.lenovopartnernetwork.com' || window.location.host == 'www.apca.com' || window.location.host == 'dealer-area.tym-tractors.com' || window.location.host == 'procial.buildrr.com') {
		config.filebrowserBrowseUrl = '/file_storage/file_storage/browser';
		config.filebrowserImageBrowseUrl = '/file_storage/file_storage/browser?type=Image';
		//config.filebrowserFlashBrowseUrl = '/file_storage/file_storage/browser?type=flash';
		config.filebrowserUploadUrl = '/file_storage/file_storage/uploader';
		//config.filebrowserFlashUploadUrl = '/file_storage/file_storage/uploader?type=flash';
		config.allowedContent = true;
	} else {
		config.filebrowserBrowseUrl = '/js/kcfinder/browse.php?type=files';
		config.filebrowserImageBrowseUrl = '/js/kcfinder/browse.php?type=img';
		config.filebrowserFlashBrowseUrl = '/js/kcfinder/browse.php?type=flash';
		config.filebrowserUploadUrl = '/js/kcfinder/upload.php?type=files';
		config.filebrowserImageUploadUrl = '/js/kcfinder/upload.php?type=img';
		config.filebrowserFlashUploadUrl = '/js/kcfinder/upload.php?type=flash';
		config.allowedContent = true;
	}
    
};
