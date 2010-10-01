<?php 
class CkeHelper extends Helper { 

    var $helpers = Array('Html', 'Javascript'); 

    function load($id, $path, $buttons) { 
        $did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v); 
        }  

        /*$code = "
  			var field = CKEDITOR.replace( '".$did."' );
  			CKFinder.setupCKEditor(field, '".$path."') ;
        ";*/ 
		if (isset($buttons)) {
			$buttonList = $this->__buttonsList($buttons);
		} else {
			$buttonList = '';
		}
		
        $code = "
  			var field = CKEDITOR.replace( '".$did."' ".$buttonList.");
        "; 
        return $this->Javascript->codeBlock($code);  
    } 
	
	function __buttonsList($buttons) {
		if (is_array($buttons)) {
			$button = ", {
					toolbar :
					[
						[";
			foreach ($buttons as $but) {
				$button .= "'".$but."',";
			}
			$button .= "]
					]
				}";
			return $button;
		} else {
			return false;
		}
	}
} 
?>