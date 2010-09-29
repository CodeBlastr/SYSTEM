<?php 
class CkeHelper extends Helper { 

    var $helpers = Array('Html', 'Javascript'); 

    function load($id, $path) { 
        $did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v); 
        }  

        /*$code = "
  			var field = CKEDITOR.replace( '".$did."' );
  			CKFinder.setupCKEditor(field, '".$path."') ;
        ";*/ 
        $code = "
  			var field = CKEDITOR.replace( '".$did."' );
        "; 
        return $this->Javascript->codeBlock($code);  
    } 
} 
?>