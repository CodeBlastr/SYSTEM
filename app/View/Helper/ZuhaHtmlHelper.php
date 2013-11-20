<?php
App::uses('HtmlHelper', 'View/Helper');

class ZuhaHtmlHelper extends HtmlHelper {
		
/**
 * Creates an HTML link.
 *
 * Overwritten to check and see if plugin is loaded (other wise removes the link)
 * Also adds a class for whether the current view is authorized.
 */
 	public function link($title, $url = null, $options = array(), $confirmMessage = false) {
		// zuha added
		if (is_array($url) && !empty($url['plugin']) && $url['plugin'] != '/' && !in_array(Inflector::camelize($url['plugin']), CakePlugin::loaded())) {
			return null;
			// end zuha added
		} else {
		// zuha added
		if (!empty($url['action'])) {
			$options['class'] = !empty($options['class']) ? $options['class'] . ' ' . $url['action'] : $url['action'];
		} // end zuha added
		
		$escapeTitle = true;
		if ($url !== null) {
			$url = $this->url($url);
		} else {
			$url = $this->url($title);
			$title = h(urldecode($url));
			$escapeTitle = false;
		}
		if (isset($options['escape'])) {
			$escapeTitle = $options['escape'];
		}
		if ($escapeTitle === true) {
			$title = h($title);
		} elseif (is_string($escapeTitle)) {
			$title = htmlentities($title, ENT_QUOTES, $escapeTitle);
		}
		if (!empty($options['confirm'])) {
 			$confirmMessage = $options['confirm'];
			unset($options['confirm']);
		}
		if ($confirmMessage) {
			$confirmMessage = str_replace("'", "\'", $confirmMessage);
			$confirmMessage = str_replace('"', '\"', $confirmMessage);
			$options['onclick'] = "return confirm('{$confirmMessage}');";
		} elseif (isset($options['default']) && $options['default'] == false) {
			if (isset($options['onclick'])) {
				$options['onclick'] .= ' event.returnValue = false; return false;';
			} else {
				$options['onclick'] = 'event.returnValue = false; return false;';
			}
			unset($options['default']);
		}
		return sprintf($this->_tags['link'], $url, $this->_parseAttributes($options), $title);
		}
	}

/**
 * Creates a formatted IMG element.
 * 
 * Overwritten -- WHY???
 */
	public function image($path, $options = array(), $extOptions = null) {
		$path = $this->assetUrl($path, $options + array('pathPrefix' => IMAGES_URL));
		$options = array_diff_key($options, array('fullBase' => '', 'pathPrefix' => ''));
		
		if (!isset($options['alt'])) {
			$options['alt'] = '';
		}
		
		$url = false;
		if (!empty($options['url'])) {
			$url = $options['url'];
			unset($options['url']);
		}
		
		$image = sprintf($this->_tags['image'], $path, $this->_parseAttributes($options, null, '', ' '));
		$image = $this->_resize($image, $path, $options, $extOptions); // zuha added
		
		if ($url) {
			return sprintf($this->_tags['link'], $this->url($url), null, $image);
		}
		return $image;
	}

/**
 * Returns a charset video embed-tag.
 */
	public function video($videopath, $options = array()) {
		$defaultoptions['width'] = '640';
		$defaultoptions['height'] = '264';
		$defaultoptions['title'] = 'Video Js';
		$defaultoptions['preload'] = 'auto';
		$defaultoptions['controls'] = 'controls';
		$defaultoptions['poster'] = '/img/noImage.jpg';
		
		$finaloptions = array_merge($defaultoptions, $options);
		
		echo $this->script('ckeditor/plugins/video_js/video', array('inline' => false));
		echo $this->css('ckeditor/plugins/video_js/video-js', array('inline' => false));
		echo $this->scriptBlock('VideoJS.setupAllWhenReady();', array('inline' => false));
		
		$videoPlayer = '<div class="video-js-box">'
			. '<video id="example_video_1" class="video-js"'
			. ' width="' . $finaloptions['width'] . '" height="' . $finaloptions['height'] . '" '
			. 'controls="' . $finaloptions['controls'] . '" preload="' . $finaloptions['preload'] . '" '
			. 'poster="' . $finaloptions['poster'] . '">';
		
		if (is_array($videopath)) {
			//if video path  param is array
			foreach ($videopath as $video) {
				$videoPlayer .= '<source src="' . $video . '" />';
				// extract the mp3 or mp4 for flash fallback
				$exts = explode('/', $video);
				$n = count($exts) - 1;
				$ext = strtolower($exts[$n]);
				if (in_array($ext, array('mp3', 'mp4'))) {
					$flashFallbackSource = $video;
				}
			}
		} else {
			//if video path param is string
			$videoPlayer .= '<source src="' . $videopath . '" />';
			$flashFallbackSource = $videopath;
		}
		
		$videoPlayer .= '<object id="flash_fallback_1" class="vjs-flash-fallback" width="' . $finaloptions['width'] . '" height="' . $finaloptions['height'] . '" type="application/x-shockwave-flash" data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">'
			. '<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" /> <param name="allowfullscreen" value="true" />'
			. '<param name="flashvars" value=\'config={"playlist":["' . $finaloptions['poster'] . '", {"url": "' . $flashFallbackSource . '","autoPlay":false,"autoBuffering":true}]}\' /> '
			. '<img src="' . $finaloptions['poster'] . '" width="' . $finaloptions['width'] . '" height="' . $finaloptions['height'] . '" alt="Poster Image" title="No video playback capabilities." />'
			. '</object>';
		$videoPlayer .= '</video>';
		$videoPlayer .= '</div>';
		return $videoPlayer;
	}

/**
 * Resizes images dynamically as they are called if extOptions is not null.
 * Uses the same parameters from $this->image() with the addition of image at the start.
 *
 * @author  RazorIT LLC
 * @link  http://www.razorit.com
 * @link  http://www.zuha.com
 * @since CakePHP 2.0.3
 * @version 1.0
 */
	private function _resize($image, $path, $options = array(), $extOptions = null) {
		if (is_array($extOptions)) {
			if (empty($options['width']) && empty($options['height'])) {
				// attempt to get the image width and height
				if ($size = getimagesize('http://' . $_SERVER['HTTP_HOST'] . $path)) {
					$options['width'] = $size[0];
					$options['height'] = $size[1];
				}
			}
			if (!empty($options['width']) && !empty($options['height'])) {
				// default extended options for images
				$extOptions['conversion'] = !empty($extOptions['conversion']) ? $extOptions['conversion'] : 'resizeCrop'; // resize, resizeCrop, crop
				$extOptions['quality'] = !empty($extOptions['quality']) ? $extOptions['quality'] : 75;
				if (strpos($path, 'theme') > 0 /* || strpos($path, 'theme') === 0 */) {
					// this only works for theme images
					$fileName = substr(strrchr($path, '/'), 1);
					$themeFolder = str_replace(strtolower('/theme/' . $this->theme . '/'), '', $path);
					$themeFolder = str_replace('/' . $fileName, '', $themeFolder);
					if ($extOptions['caller'] === 'Media') {
						$fileName = str_replace('images\\', '', $fileName);
						$id = urldecode(str_replace('images\\', '', $fileName));
						$imgFolder = ROOT . DS . SITE_DIR . DS . 'Locale' . DS . 'View' . DS . 'webroot' . DS . $themeFolder . DS . 'images' . DS;
					} else {
						$id = urldecode($fileName);
						$imgFolder = ROOT . DS . SITE_DIR . DS . 'Locale' . DS . 'View' . DS . 'webroot' . DS . $themeFolder . DS;
					}
					$convertedFile = $this->_resizeImage(
						$extOptions['conversion'],
						$id,
						$imgFolder,
						'tmp_' . $options['width'] . $options['height'] . $extOptions['conversion'],
						$options['width'],
						$options['height'],
						$extOptions['quality']
					);
					if ($convertedFile) {
						$htmlTag = str_replace($fileName, $convertedFile['path'], $image);
						$htmlTag = preg_replace('/\width=".*?"/', 'width="' . $convertedFile['width'] . '"', $htmlTag);
						$htmlTag = preg_replace('/height=".*?"/', 'height="' . $convertedFile['height'] . '"', $htmlTag);
						return $htmlTag;
					} else {
						return $image;
					}
				}
			} else {
				debug('Width & height attributes are required for dynamic image conversions.');
				//break;
			}
		} else {
			return $image;
		}
	}

/**
 * PImageComponent: component to resize or crop images
 * @author: Wendy Perkins aka The Perkster
 * @website: http://www.perksterdesigns.com/
 * @license: MIT
 * @version: 0.8.3.1
 * @param $cType - the conversion type: resize (default), resizeCrop (square), crop (from center)
 * @param $id - image filename
 * @param $imgFolder  - the folder where the image is
 * @param $newName - include extension (if desired)
 * @param $newWidth - the  max width or crop width
 * @param $newHeight - the max height or crop height
 * @param $quality - the quality of the image
 * @param $bgcolor - this was from a previous option that was removed, but required for backward compatibility
 */
	protected function _resizeImage($cType = 'resize', $id, $imgFolder, $newName = false, $newWidth = false, $newHeight = false, $quality = 75, $bgcolor = false) {
		$img = $imgFolder . $id;
		if (file_exists($img)) {
			list($oldWidth, $oldHeight, $type) = getimagesize($img);
		$ext = $this->image_type_to_extension($type);

		// check for and create cacheFolder
		$cacheFolder = 'cache';
		$cachePath = $imgFolder . $cacheFolder;
		if (is_dir($cachePath)) {
			// do nothing the cache dir exists
		} else {
			if (mkdir($cachePath)) {
				// do nothing the cache dir exists
			} else {
				debug('Could not make images ' . $cachePath . ', and it doesn\'t exist.');
				break;
			}
		}

		//check to make sure that the file is writeable, if so, create destination image (temp image)
		if (is_writeable($cachePath)) {
			if ($newName) {
				$dest = $cachePath . DS . $newName . '.' . $id;
			} else {
				$newName = 'tmp_' . $id;
				$dest = $cachePath . DS . $newName;
			}
		} else {
			//if not let developer know
			$imgFolder = substr($imgFolder, 0, strlen($imgFolder) - 1);
			$imgFolder = substr($imgFolder, strrpos($imgFolder, '\\') + 1, 20);
			debug("You must allow proper permissions for image processing. And the folder has to be writable.");
			debug("Run \"chmod 777 on '$imgFolder' folder\"");
			exit();
		}

		//check to make sure that something is requested, otherwise there is nothing to resize.
		//although, could create option for quality only
		if ($newWidth || $newHeight) {
			// check to make sure temp file doesn't exist from a mistake or system hang up. If so delete.
			if (file_exists($dest)) {
				$size = @getimagesize($dest);
				return array(
				'path' => $cacheFolder . '/' . $newName . '.' . $id,
				'width' => $size[0],
				'height' => $size[1],
				);
			} else {
				switch ($cType) {
					default:
					case 'resize':
						// Maintains the aspect ration of the image and makes sure that it fits
						// within the maxW(newWidth) and maxH(newHeight) (thus some side will be smaller)
						$widthScale = 2;
						$heightScale = 2;
	
						if ($newWidth) {
							$widthScale = $newWidth / $oldWidth;
						}
						if ($newHeight) {
							$heightScale = $newHeight / $oldHeight;
						}
						if ($widthScale < $heightScale) {
							$maxWidth = $newWidth;
							$maxHeight = false;
						} elseif ($widthScale > $heightScale) {
							$maxHeight = $newHeight;
							$maxWidth = false;
						} else {
							$maxHeight = $newHeight;
							$maxWidth = $newWidth;
						}
	
						if ($maxWidth > $maxHeight) {
							$applyWidth = $maxWidth;
							$applyHeight = ($oldHeight * $applyWidth) / $oldWidth;
						} elseif ($maxHeight > $maxWidth) {
							$applyHeight = $maxHeight;
							$applyWidth = ($applyHeight * $oldWidth) / $oldHeight;
						} else {
							$applyWidth = $maxWidth;
							$applyHeight = $maxHeight;
						}
						$startX = 0;
						$startY = 0;
						break;
						case 'resizeCrop':
							// -- resize to max, then crop to center
							$ratioX = $newWidth / $oldWidth;
							$ratioY = $newHeight / $oldHeight;
		
							if ($ratioX < $ratioY) {
								$startX = round(($oldWidth - ($newWidth / $ratioY)) / 2);
								$startY = 0;
								$oldWidth = round($newWidth / $ratioY);
								$oldHeight = $oldHeight;
							} else {
								$startX = 0;
								$startY = round(($oldHeight - ($newHeight / $ratioX)) / 2);
								$oldWidth = $oldWidth;
								$oldHeight = round($newHeight / $ratioX);
							}
							$applyWidth = $newWidth;
							$applyHeight = $newHeight;
							break;
						case 'crop':
							// -- a straight centered crop
							$startY = ($oldHeight - $newHeight) / 2;
							$startX = ($oldWidth - $newWidth) / 2;
							$oldHeight = $newHeight;
							$applyHeight = $newHeight;
							$oldWidth = $newWidth;
							$applyWidth = $newWidth;
							break;
					}

					switch ($ext) {
						case 'gif' :
							$oldImage = imagecreatefromgif($img);
							break;
						case 'png' :
							$oldImage = imagecreatefrompng($img);
							break;
						case 'jpg' :
						case 'jpeg' :
							$oldImage = imagecreatefromjpeg($img);
							break;
						default :
							//image type is not a possible option
							return false;
							break;
					}
	
					//create new image
					$newImage = imagecreatetruecolor($applyWidth, $applyHeight);
	
					if ($bgcolor) {
						//set up background color for new image
						sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
						$newColor = ImageColorAllocate($newImage, $red, $green, $blue);
						imagefill($newImage, 0, 0, $newColor);
					};
	
					// preserve transparency
					if ($ext == 'gif' || $ext == 'png') {
						imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
						imagealphablending($newImage, false);
						imagesavealpha($newImage, true);
					}
	
					//put old image on top of new image
					imagecopyresampled($newImage, $oldImage, 0, 0, $startX, $startY, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
					switch ($ext) {
						case 'gif' :
							imagegif($newImage, $dest, $quality);
							break;
						case 'png' :
							imagepng($newImage, $dest, $quality);
							break;
						case 'jpg' :
						case 'jpeg' :
							imagejpeg($newImage, $dest, $quality);
							break;
						default :
							return false;
							break;
					}
	
					imagedestroy($newImage);
					imagedestroy($oldImage);
	
					if (!$newName) {
						unlink($img);
						rename($dest, $img);
					}
	
					$size = @getimagesize($cacheFolder . '/' . $newName . '.' . $id);
					return array(
						'path' => $cacheFolder . '/' . $newName . '.' . $id,
						'width' => $applyWidth,
						'height' => $applyHeight,
					);
				}
			} else {
				return false;
			}
		} else {
			return false; // end the check for if the file to convert even exists
		}
	}

/**
 * Image type to extension method
 * 
 */
	public function image_type_to_extension($imagetype) {
		if (empty($imagetype)) {
			return false;
		}
		switch ($imagetype) {
			case IMAGETYPE_GIF : return 'gif';
			case IMAGETYPE_JPEG : return 'jpg';
			case IMAGETYPE_PNG : return 'png';
			case IMAGETYPE_SWF : return 'swf';
			case IMAGETYPE_PSD : return 'psd';
			case IMAGETYPE_BMP : return 'bmp';
			case IMAGETYPE_TIFF_II : return 'tiff';
			case IMAGETYPE_TIFF_MM : return 'tiff';
			case IMAGETYPE_JPC : return 'jpc';
			case IMAGETYPE_JP2 : return 'jp2';
			case IMAGETYPE_JPX : return 'jpf';
			case IMAGETYPE_JB2 : return 'jb2';
			case IMAGETYPE_SWC : return 'swc';
			case IMAGETYPE_IFF : return 'aiff';
			case IMAGETYPE_WBMP : return 'wbmp';
			case IMAGETYPE_XBM : return 'xbm';
			default : return false;
		}
	}

/**
 * Tag element function
 * 
 * Replaces {element: Plugin.folder/element-name var1=x,var2=y} with the tag php code : $this->Element('Plugin.folder/element-name', array('var1' => 'x', 'var2' => 'y'));
 * 
 * @param object $View
 * @param string $content
 * @param array $options
 */
	public function tagElement($View, $content, $options = array()) {
		// matches element template tags like {element: plugin.name}
		preg_match_all ("/(\{element: (.*?)([^\}]*)\})/", $content, $matches); // a little shorter
		$i=0;
		foreach ($matches[0] as $elementMatch) {
			$element = $this->parseTag(trim($matches[3][$i]));
			$replacement = !empty($options['templateEditing']) ? sprintf('<li data-template-tag="element: %s">%s</li>', $element, $View->element($element['name'], $element['variables'])) : $View->element($element['name'], $element['variables']);
			$content = str_replace($elementMatch, $replacement, $content);
			$i++;
		}
		return $content;
	}
  
/**
 * Parse tag function
 * 
 * parses a string {element: some-name var1="x x",var2=y} into array('element' => 'some-name', 'variables' => array('var1' => 'x x', 'var2' => 'y'));
 * 
 * @param string $tag
 */
	public function parseTag($tag) {
		$variables = array();
		$vars = explode(' ', $tag, 2);  // limit to two
		$name = $vars[0];
		if (strpos($tag, '=')) {
			$vars = explode(',', $vars[1]);
			foreach ($vars as $var) {
				$option = explode('=', $var);
				$variables[$option[0]] = str_replace('"', '', $option[1]); // remove quotes
			}
		}
		return array('name' => $name, 'variables' => $variables);
	}

}
