<?php

$source = "../../sites/veevee.com";
$target = "../../sites/xyz";
full_copy_a_directory( $source, $target );
/**
 * This function is used to create folders recursively.
 * Param $dir - directory name
 * Param $mode - directory access mode
 * Param $recursive - create directory recursive, default true
 */

function mkdirs($dir, $mode = 0777, $recursive = true)
{	
	if( is_null($dir) || $dir === "" ){		
		return FALSE;
	}
	if( is_dir($dir) || $dir === "/" ){		
		return TRUE;
	}
	if( mkdirs(dirname($dir), $mode, $recursive) ){		
		return mkdir($dir, $mode);
	}	
	return FALSE;
}


//This function is used to copy a full directory

function full_copy_a_directory( $source, $target ) {
	if ( is_dir( $source ) ) {
		mkdirs( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy_a_directory( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
 
		$d->close();
	}else {
		copy( $source, $target );
	}
}
?>