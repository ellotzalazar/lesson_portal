<?php
/**
 * This file contains the custom contants and functions
 * of the app
 */

// Custom CONSTANTS ------------------------------------------------------------
define('SITE_URL',  'http://192.168.43.206/lessonrepo_web');
define('OFFICIAL_EMAIL', 'phpsample0001@gmail.com');
define('SITE_NAME', 'Online Lesson Repository');
define('SITE_NAME_LONG', 'for Cavite State University');
define('SITE_NAME_SM', '<b>O</b>L<b>R</b>');

//Database Constants
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_TIMEZONE', 'UTC');
define('DB_NAME', 'lessonrepo');

define('USER_IMAGE_PATH', DS . 'img' . DS . 'users' . DS);
/*
 * Generates string for hash/session field
 */
function randomString($len = 40) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $len; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

/*
 * Adds 1 month to current date for API session validity
 */
function sessionExpiryDate(){
  return date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " +1 month"));
}

function formatSeconds( $seconds )
{
    $hours = 0;
    $milliseconds = str_replace( "0.", '', $seconds - floor( $seconds ) );

    if ( $seconds > 3600 ){
        $hours = floor( $seconds / 3600 );
    }
    $seconds = $seconds % 3600;


    return str_pad( $hours, 2, '0', STR_PAD_LEFT )
       . gmdate( ':i:s', $seconds )
       . ($milliseconds ? ".$milliseconds" : '')
    ;
}

function isInterlaced( $filename ) {
   $handle = fopen($filename, "r");
   $contents = fread($handle, 32);
   fclose($handle);
   return( ord($contents[28]) != 0 );
}

function removeInterlaced($filename){
  // Create an image instance
  $im = imagecreatefrompng($filename);

  unlink($filename);

  // Disable interlancing
  imageinterlace($im, false);

  // Save the interlaced image
  imagepng($im, $filename);
  imagedestroy($im);
}

function resize_image($file, $type, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    if ($type == 'image/png'){
        $input=imagecreatefrompng($file);
        $w = imagesx($input);
        $h = imagesy($input);
        $src = imagecreatetruecolor($w, $h);
        $white = imagecolorallocate($src,  255, 255, 255);
        imagefilledrectangle($src, 0, 0, $w, $h, $white);
        imagecopy($src, $input, 0, 0, 0, 0, $w, $h);
    }
    else if ($type == 'image/gif'){
        $input=imagecreatefromgif($file);
        $w = imagesx($input);
        $h = imagesy($input);
        $src = imagecreatetruecolor($w, $h);
        $white = imagecolorallocate($src,  255, 255, 255);
        imagefilledrectangle($src, 0, 0, $w, $h, $white);
        imagecopy($src, $input, 0, 0, 0, 0, $w, $h);
    }
    else if ($type == 'image/bmp')
        $src=imagecreatefrombmp($file);
    else
        $src=imagecreatefromjpeg($file);

    // $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

// END of Custom Functions -----------------------------------------------------