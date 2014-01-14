/**
*
*/

(function(){

    CKEDITOR.plugins.add( 'sharelink', {
        icons: 'sharelink',
        init: function( editor ) {
            editor.addCommand( 'sharelink', new CKEDITOR.dialogCommand( 'sharelinkDialog' ));

            editor.ui.addButton('sharelink', {
                label: 'sharelink',
                command: 'sharelink',
                toolbar: 'insert',
                icon: this.path + "images/" + (CKEDITOR.env.hidpi ? "hidpi/" : "") + "anchor.png"
            });

            CKEDITOR.dialog.add( 'sharelinkDialog', this.path + 'dialogs/dialog.js' );
        }


    });


})();