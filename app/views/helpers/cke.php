<?php 
class CkeHelper extends Helper { 

    var $helpers = Array('Html', 'Javascript'); 

    function load($id, $settings = null) { 
		App::import('Helper', 'Html');
		$this->Html = new HtmlHelper;	
		
		# this is the id to replace the following two foreach's change it into the id format that cake uses from the field name.
        $did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v);
        }
		
		$did = str_replace('[', '_', $did);
		$did = str_replace('Data_', '', $did);
		$did = str_replace(']', '', $did);		
		$did = Inflector::camelize($did);

        /*$code = "
  			var field = CKEDITOR.replace( '".$did."' );
  			CKFinder.setupCKEditor(field, '".$path."') ;
        ";*/ 
		$configuration = $this->__config($settings);
		
        $code = "
  			var field = CKEDITOR.replace( '".$did."', {".$configuration."});
        "; 
        return $this->Html->scriptBlock($code);  
    } 
	
	
	function __config($settings) {
		# color settings
		if (!empty($settings['uiColor'])) {
			$color = "uiColor: '".$settings['uiColor']."',";
		}
		
		
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
		
		
		#button settings
		if (!empty($settings['buttons'])) {
			$button = " 
					toolbar :
					[
						[";
			foreach ($settings['buttons'] as $but) {
				$button .= "'".$but."',";
			}
			$button .= "]
					],";
					
		}
		
		#stylesheet settings
		if(!empty($settings['contentsCss'])) {
			if (!empty($output)) {
				$output .= "contentsCss : ['".$settings['contentsCss']."'],";
			} else {
				$output = "contentsCss : ['".$settings['contentsCss']."'],";
			}	
		} 
		
		
		if (!empty($color)) {
			# add in color if it exsists
			if (!empty($output)) {
				$output .= $color;
			} else {
				$output = $color;
			}				
		}
		if (!empty($paths)) {
			# add in color if it exsists
			if (!empty($output)) {
				$output .= $paths;
			} else {
				$output = $paths;
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
		
		/**
		 * @todo 		put this at the top so that you can get rid of all the if empty output things
		 */
		if (!empty($output)) {
			$output .= "extraPlugins : 'autogrow',";
		} else {
			$output = "extraPlugins : 'autogrow',";
		}
		
		
		if (!empty($output)) {
			return $output;
		} else {
			return false;
		}
	}
	
} 
?>