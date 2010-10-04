	<?php 
class CkeHelper extends Helper { 

    var $helpers = Array('Html', 'Javascript'); 

    function load($id, $path, $settings) { 
        $did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v); 
        }  

        /*$code = "
  			var field = CKEDITOR.replace( '".$did."' );
  			CKFinder.setupCKEditor(field, '".$path."') ;
        ";*/ 
		if (!empty($settings)) {
			$configuration = $this->__config($settings);
		} else {
			$configuration = '';
		}
		
        $code = "
  			var field = CKEDITOR.replace( '".$did."', {".$configuration."});
        "; 
        return $this->Javascript->codeBlock($code);  
    } 
	
	# this should be updated so that it works from an array
	# like this $config = array('buttons' => array('button1', 'button2'), 'uiColor' => '#000000');
	function __config($settings) {
		# color settings
		if (!empty($settings['uiColor'])) {
			$color = "uiColor: '".$settings['uiColor']."',";
		}
		
		#button settings
		if (is_array($settings['buttons'])) {
			$button = "
					toolbar :
					[
						[";
			foreach ($settings['buttons'] as $but) {
				$button .= "'".$but."',";
			}
			$button .= "]
					]";
					
		}
		
		if (!empty($color)) {
			# add in color if it exsists
			if (!empty($output)) {
				$output .= $color;
			} else {
				$output = $color;
			}				
		}
		if (!empty($button)) {
			# add in buttons if they exist
			if (!empty($output)) {
				$output .= $button;
			} else {
				$output = $button;
			}
		}
		
		if (!empty($output)) {
			return $output;
		} else {
			return false;
		}
	}
	
} 
?>