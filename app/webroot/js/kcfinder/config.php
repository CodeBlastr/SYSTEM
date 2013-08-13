<?php

// See http://kcfinder.sunhater.com/install for setting descriptions

$_CONFIG = array(

// GENERAL SETTINGS

    'disabled' => false,
    'theme' => "oxygen",
  	// 'uploadURL' => $uploadUrl,
  	// 'uploadDir' => $uploadDir,

    'types' => array(
        // CKEditor & FCKEditor types
        'files'   =>  "zip doc docx eot ttf otf pdf xls odt csv psd ai fla eps png ppt html htm txt gif jpg jpeg wav mp3 mov mp4 swf avi wmv flv css js xml swf",
        'flash'   =>  "swf",
        'img'  =>  "*img",
    ),


// IMAGE SETTINGS

    'imageDriversPriority' => "imagick gmagick gd",
    'jpegQuality' => 90,
    'thumbsDir' => ".thumbs",

    'maxImageWidth' => 0,
    'maxImageHeight' => 0,

    'thumbWidth' => 100,
    'thumbHeight' => 100,

    'watermark' => "",


// DISABLE / ENABLE SETTINGS

    'denyZipDownload' => false,
    'denyUpdateCheck' => false,
    'denyExtensionRename' => false,


// PERMISSION SETTINGS

    'dirPerms' => 0755,
    'filePerms' => 0644,

    'access' => array(

        'files' => array(
            'upload' => true,
            'delete' => true,
            'copy'   => true,
            'move'   => true,
            'rename' => true
        ),

        'dirs' => array(
            'create' => true,
            'delete' => true,
            'rename' => true
        )
    ),

    'deniedExts' => "exe com msi bat php phps phtml php3 php4 cgi pl",


// MISC SETTINGS

    'filenameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'dirnameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'mime_magic' => "",

    'cookieDomain' => "",
    'cookiePath' => "",
    'cookiePrefix' => 'CAKEPHP',


// THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION SETTINGS
    '_check4htaccess' => true,
	'_sessionVar' => $_SESSION['KCFINDER'],
);