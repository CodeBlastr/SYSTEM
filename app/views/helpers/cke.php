<<<<<<< HEAD
<?php 
=======
	<?php 
>>>>>>> 71fe1cf1216af5445d2f6e177f9920fc444140cc
class CkeHelper extends Helper { 

    var $helpers = Array('Html', 'Javascript'); 

<<<<<<< HEAD
    function load($id, $path, $settings = null) { 		
		# I don't know what path is used for, might be pointless
=======
    function load($id, $path, $settings) { 
>>>>>>> 71fe1cf1216af5445d2f6e177f9920fc444140cc
        $did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v); 
        }  

        /*$code = "
  			var field = CKEDITOR.replace( '".$did."' );
  			CKFinder.setupCKEditor(field, '".$path."') ;
        ";*/ 
<<<<<<< HEAD
		$configuration = $this->__config($settings);
=======
		if (!empty($settings)) {
			$configuration = $this->__config($settings);
		} else {
			$configuration = '';
		}
>>>>>>> 71fe1cf1216af5445d2f6e177f9920fc444140cc
		
        $code = "
  			var field = CKEDITOR.replace( '".$did."', {".$configuration."});
        "; 
        return $this->Javascript->codeBlock($code);  
    } 
	
<<<<<<< HEAD
	
=======
	# this should be updated so that it works from an array
	# like this $config = array('buttons' => array('button1', 'button2'), 'uiColor' => '#000000');
>>>>>>> 71fe1cf1216af5445d2f6e177f9920fc444140cc
	function __config($settings) {
		# color settings
		if (!empty($settings['uiColor'])) {
			$color = "uiColor: '".$settings['uiColor']."',";
		}
		
<<<<<<< HEAD
		
		# path settings
		if (defined('SITE_DIR')) {
			$paths = '';
			# default file paths needed if this is a multiple site setup
			$paths .= "filebrowserBrowseUrl: '/js/kcfinder/browse.php?type=files&kcfinderuploadDir=".SITE_DIR."',";
			$paths .= "filebrowserImageBrowseUrl: '/js/kcfinder/browse.php?type=images&kcfinderuploadDir=".SITE_DIR."',";
			$paths .= "filebrowserFlashBrowseUrl: '/js/kcfinder/browse.php?type=flash&kcfinderuploadDir=".SITE_DIR."',";
			$paths .= "filebrowserUploadUrl: '/js/kcfinder/upload.php?type=files&kcfinderuploadDir=".SITE_DIR."',";
			$paths .= "filebrowserImageUploadUrl: '/js/kcfinder/upload.php?type=images&kcfinderuploadDir=".SITE_DIR."',";
			$paths .= "filebrowserFlashUploadUrl: '/js/kcfinder/upload.php?type=flash&kcfinderuploadDir=".SITE_DIR."',";
		}
					
		if (!empty($settings['paths'])) {
			# if paths are defined over write the default path settings
			if (!empty($settings['paths']['filebrowserBrowseUrl'])) {
				$paths .= "filebrowserBrowseUrl: '".$settings['paths']['filebrowserBrowseUrl']."',";
			} 
			if (!empty($settings['paths']['filebrowserImageBrowseUrl'])) {
				$paths .= "filebrowserImageBrowseUrl: '".$settings['paths']['filebrowserImageBrowseUrl']."',";
			} 
			if (!empty($settings['paths']['filebrowserFlashBrowseUrl'])) {
				$paths .= "filebrowserFlashBrowseUrl: '".$settings['paths']['filebrowserFlashBrowseUrl']."',";
			} 
			if (!empty($settings['paths']['filebrowserUploadUrl'])) {
				$paths .= "filebrowserUploadUrl: '".$settings['paths']['filebrowserUploadUrl']."',";
			} 
			if (!empty($settings['paths']['filebrowserImageUploadUrl'])) {
				$paths .= "filebrowserImageUploadUrl: '".$settings['paths']['filebrowserImageUploadUrl']."',";
			} 
			if (!empty($settings['paths']['filebrowserFlashUploadUrl'])) {
				$paths .= "filebrowserFlashUploadUrl: '".$settings['paths']['filebrowserFlashUploadUrl']."',";
			} 
		}
		
		
=======
>>>>>>> 71fe1cf1216af5445d2f6e177f9920fc444140cc
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
<<<<<<< HEAD
		if (!empty($paths)) {
			# add in color if it exsists
			if (!empty($output)) {
				$output .= $paths;
			} else {
				$output = $paths;
			}				
		}
=======
>>>>>>> 71fe1cf1216af5445d2f6e177f9920fc444140cc
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