<?php 
/**
 * A helper for loading ckeditor and the config variables for it. 
 *
 * @todo Need to set default variables, like $this->uiColor, instead of the return thing from the _config function.
 */
class CkeHelper extends Helper { 

    public $helpers = array('Html', 'Javascript'); 

    public function load($id, $settings = null) { 		
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
		$configuration = $this->_config($settings);
		
        $code = "
  			$('#".$did."').ckeditor(function(){ 
				//$('.cke_toolbox').hide();
				//$('.cke_toolbox_collapser').addClass('cke_toolbox_collapser_min');
				}, 
				{".$configuration."});
        "; 
        return $this->Html->scriptBlock($code);  
    } 
	
	
	protected function _fileManager() {
		if (CakeSession::read('Auth.User') && defined('SITE_DIR')) {
			CakeSession::write('KCFINDER.disabled', false);
			CakeSession::write('KCFINDER.uploadURL', '/theme/default/upload/' . CakeSession::read('Auth.User.id'));
			CakeSession::write('KCFINDER.uploadDir', '../../../../' . SITE_DIR . '/View/Themed/Default/webroot/upload/' . CakeSession::read('Auth.User.id'));
			
			# path settings
			$paths = '';
			$paths .= "filebrowserBrowseUrl: '/js/kcfinder/browse.php?type=files',";
			$paths .= "filebrowserImageBrowseUrl: '/js/kcfinder/browse.php?type=img',";
			$paths .= "filebrowserFlashBrowseUrl: '/js/kcfinder/browse.php?type=flash',";
			$paths .= "filebrowserUploadUrl: '/js/kcfinder/upload.php?type=files',";
			$paths .= "filebrowserImageUploadUrl: '/js/kcfinder/upload.php?type=img',";
			$paths .= "filebrowserFlashUploadUrl: '/js/kcfinder/upload.php?type=flash',";
		
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
			return $paths;
		} else {
			return null;
		}
	}
	
	protected function _config($settings) {
		# color settings
		if (!empty($settings['uiColor'])) {
			$color = "uiColor: '".$settings['uiColor']."',";
		}
		
		$paths = $this->_fileManager();
		
		
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
         /*
		if (!empty($output)) {
			$output .= "extraPlugins : 'autogrow',";
		} else {
			$output = "extraPlugins : 'autogrow',";
		}
			*/	
			
			
			/*  This shows a button which gives instant iframe access to the file manager
			echo '<style type="text/css">
#kcfinder_div {
    display: none;
    position: absolute;
	top: 300px;
    width: 670px;
    height: 400px;
    background: #e0dfde;
    border: 2px solid #3687e2;
    border-radius: 6px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    padding: 1px;
}
</style>
 
<script type="text/javascript">
function openKCFinder(field) {
    var div = document.getElementById("kcfinder_div");
    if (div.style.display == "block") {
        div.style.display = "none";
        div.innerHTML = "";
        return;
    }
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            field.value = url;
            div.style.display = "none";
            div.innerHTML = "";
        }
    };
    div.innerHTML = "<iframe name=\"kcfinder_iframe\" src=\"/js/kcfinder/browse.php?type=files&kcfinderuploadDir='.$dir.'&dir=files/public" +
        " frameborder=\"0\" width=\"100%\" height=\"100%\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" />";
    div.style.display = "block";
}
</script>
 
Selected file:
<input type="text" readonly="readonly" value="Click here to browse the server" onclick="openKCFinder(this)" style="width:600px;cursor:pointer" /><br />
<div id="kcfinder_div"></div>';  */  
		
		if (!empty($output)) {
			return $output;
		} else {
			return false;
		}
	}
	
} 