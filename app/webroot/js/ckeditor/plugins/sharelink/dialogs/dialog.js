CKEDITOR.dialog.add( 'sharelinkDialog', function( editor ) {

    return {
        title: 'Share Link',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'main-tab',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'mylink',
                        label: 'URL',
                        validate: function(url){
                            /*var RegExp = /(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                            return true;
                            if(RegExp.test(url)){
                                return true;
                            }else{
                                return false;
                            }*/
                            return true;
                        }
                    },
                    {
                        type: 'text',
                        id: 'mytitle',
                        label: 'Title (Optional)'
                    }
                ]
            }

        ],
        onOk: function() {
            var dialog = CKEDITOR.dialog.getCurrent(),
                inputURL = dialog.getContentElement('main-tab','mylink').getValue(),
                urlTitle = dialog.getContentElement('main-tab','mytitle').getValue(),
                content = '';
                if(urlTitle){
                    content = '<a href="http://'+inputURL+'" target="_blank">'+urlTitle+'</a>';
                }else{
                    content = '<a href="'+inputURL+'">'+inputURL+'</a>';
                }
                $.ajax({
                    url: '/blogs/blog_posts/getMetaDescripton/'+inputURL,
                    success: function(response){
                        editor.insertHtml(content+'<br />'+response+'<br />');
                    },
                    dataType: 'html'
                });





        }
    };
});