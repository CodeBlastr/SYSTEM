CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'mediaembed';

    config.toolbar = [
        {
            name: 'default', 
            items: ['Bold','Italic','-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList']
        },
        {
            name: 'default2',
            items: ['Image','Link','Unlink','MediaEmbed']
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
            items: ['Format','Font','FontSize']
        },
	  ];
	config.skin = 'moono';
	
	config.filebrowserBrowseUrl = '/js/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = '/js/kcfinder/browse.php?type=img';
	config.filebrowserFlashBrowseUrl = '/js/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = '/js/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = '/js/kcfinder/upload.php?type=img';
	config.filebrowserFlashUploadUrl = '/js/kcfinder/upload.php?type=flash';
	config.allowedContent = true;
};