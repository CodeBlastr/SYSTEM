<?php 
/**
 * A helper for loading ckeditor and the config variables for it. 
 *
 * @todo Need to set default variables, like $this->uiColor, instead of the return thing from the _config function.
 */
class CkeHelper extends Helper { 

    public $helpers = array('Html', 'Javascript'); 

    public function load($id, $settings = null) { 		
		// this is the id to replace the following two foreach's change it into the id format that cake uses from the field name.
		$did = ''; 
        foreach (explode('.', $id) as $v) { 
            $did .= ucfirst($v);
        }
		
        $css = '<style type="text/css">.richtext {position: relative;} .ckeditorLinks {position: absolute; right: 6px; top: 3px;} .ckeditorLinks a {color: #000; text-decoration: none; cursor: pointer} .ckeditorLinks a:hover {text-decoration: none; color: #000;}</style>';
		$did = str_replace('[', '_', $did);
		$did = str_replace('Data_', '', $did);
		$did = str_replace(']', '', $did);		
		$did = Inflector::camelize($did);

		$configuration = $this->_config($settings);
        $code = "
            
            function toggleExtras() {
    			$('.cke_toolbar_break').nextAll().toggle();
            }
            function ExecuteCommand( commandName ) {
                var editor = CKEDITOR.instances.$did;
                if ( editor.mode == 'wysiwyg' ) {
		            editor.execCommand( commandName );
                    $('#exec-source').html('<i class=\"icon-edit\"></i> DESIGN');
	            } else {
    	            editor.execCommand( commandName );
                    $('#exec-source').html('<i class=\"icon-wrench\"></i> HTML');
                }
            }
            $('#".$did."').ckeditor('instanceReady', function() { 
    			toggleExtras();
			}, {".$configuration."});
        "; 
        return $css . $this->Html->scriptBlock($code);  
        
        /* these will be useful in the future
        http://docs.ckeditor.com/#!/api/CKEDITOR.config
        
        config.templates_files = [
            '/editor_templates/site_default.js',
            'http://www.example.com/user_templates.js
        ]; */
    } 
	
	
	protected function _fileManager() {
		if (CakeSession::read('Auth.User') && defined('SITE_DIR')) {
			CakeSession::write('KCFINDER.disabled', false);
			CakeSession::write('KCFINDER.uploadURL', '/theme/default/upload/' . CakeSession::read('Auth.User.id'));
			CakeSession::write('KCFINDER.uploadDir', '../../../../' . SITE_DIR . '/Locale/View/webroot/upload/' . CakeSession::read('Auth.User.id'));
			
			// path settings
			$paths = '';
			$paths .= "filebrowserBrowseUrl: '/js/kcfinder/browse.php?type=files',";
			$paths .= "filebrowserImageBrowseUrl: '/js/kcfinder/browse.php?type=img',";
			$paths .= "filebrowserFlashBrowseUrl: '/js/kcfinder/browse.php?type=flash',";
			$paths .= "filebrowserUploadUrl: '/js/kcfinder/upload.php?type=files',";
			$paths .= "filebrowserImageUploadUrl: '/js/kcfinder/upload.php?type=img',";
			$paths .= "filebrowserFlashUploadUrl: '/js/kcfinder/upload.php?type=flash',";
		
			if (!empty($settings['paths'])) {
				// if paths are defined over write the default path settings
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
			return $paths;
		} else {
			return null;
		}
	}
	
	protected function _config($settings) {
		// color settings
		if (!empty($settings['uiColor'])) {
			$color = "uiColor: '".$settings['uiColor']."',";
		}
		
		$paths = $this->_fileManager();
		
		// button settings
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
		
		// stylesheet settings
		if(!empty($settings['contentsCss'])) {
			if (!empty($output)) {
				$output .= "contentsCss : ['".$settings['contentsCss']."'],";
			} else {
				$output = "contentsCss : ['".$settings['contentsCss']."'],";
			}	
		} 
		
		
		if (!empty($color)) {
			// add in color if it exsists
			if (!empty($output)) {
				$output .= $color;
			} else {
				$output = $color;
			}				
		}
		if (!empty($paths)) {
			// add in color if it exsists
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
		
		if (!empty($output)) {
			return $output;
		} else {
			return false;
		}
	}
} 