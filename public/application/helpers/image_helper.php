<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function image_text($image,$width,$size,$x,$y,$text,$bold = FALSE)
{
	$font = $bold ? 'arialbd' : 'arial';
	$text = wrap($text,'fonts/'.$font.'.ttf',$size,$width - 10);
	imagettftext($image, $size, 0, $x, $y, imagecolorallocate($image,0,0,0), 'fonts/'.$font.'.ttf', $text);
	return calculateTextBox($text,'fonts/'.$font.'.ttf',$size)['height'];
}

/**
 * Wrap the text so it's fits the image width
 * @param  string  $text      Text
 * @param  string  $fontFile  Font file
 * @param  integer $fontSize  Font size
 * @param  integer $width     Image width
 * @param  integer $fontAngle Font angle
 * @return string             The wrapped text
 */
function wrap($text,$fontFile,$fontSize,$width,$fontAngle = 0)
{	
	$ret = "";
	
	$arr = explode(' ', $text);
	
	foreach ( $arr as $word ){
	
		$teststring = $ret.' '.$word;
		$testbox = imagettfbbox($fontSize, $fontAngle, $fontFile, $teststring);
		if ( $testbox[2] > $width ){
			$ret.=($ret==""?"":"\n").$word;
		} else {
			$ret.=($ret==""?"":' ').$word;
		}
	}
	
	return $ret;
}

/**
 * Get text image size
 * @param  string 	$text      Text
 * @param  string 	$fontFile  Font file
 * @param  integer 	$fontSize  Font size
 * @param  integer 	$fontAngle Font angle
 * @return array           	   Array with dimensions
 */
function calculateTextBox($text,$fontFile,$fontSize,$fontAngle = 0)
{ 
	$rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text); 
	$minX = min(array($rect[0],$rect[2],$rect[4],$rect[6])); 
	$maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6])); 
	$minY = min(array($rect[1],$rect[3],$rect[5],$rect[7])); 
	$maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7])); 
	
	return array( 
	 "left"   => abs($minX) - 1, 
	 "top"    => abs($minY) - 1, 
	 "width"  => $maxX - $minX, 
	 "height" => $maxY - $minY, 
	 "box"    => $rect 
	); 
} 

/**
 * Resize and crop image
 * @param  string  $image  The image
 * @param  integer $width  New width
 * @param  integer $height New height
 * @return string          The resized and croped image
 */
function thumb($image,$width = 220,$height = 220)
{
	if($image)
	{
		// Get CI stuff
		$CI =& get_instance();

		// Get the filename
		$fileinfo = pathinfo($image);

		// Thumb location
		$image_thumb = $fileinfo['dirname'] . '/thumb/' . $width . '-' . $fileinfo['basename'];

		// Thumb generated?
		if(!file_exists($image_thumb))
		{
			$image = imagecreatefromstring(file_get_contents($image));

			// Set new size
			$thumb_width = $width;
			$thumb_height = $height;

			// Get image size
			$width = imagesx($image);
			$height = imagesy($image);

			// Calculate ratio
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;

			// Image wider than new size
			if ( $original_aspect >= $thumb_aspect )
			{
				$new_height = $thumb_height;
				$new_width = $width / ($height / $thumb_height);
			}
			// New size wider than the image
			else
			{
				$new_width = $thumb_width;
				$new_height = $height / ($width / $thumb_width);
			}

			// Create image
			$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

			// Resize and crop
			imagecopyresampled($thumb,
									 $image,
									 0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
									 0 - ($new_height - $thumb_height) / 2, // Center the image vertically
									 0, 0,
									 $new_width, $new_height,
									 $width, $height);
			// Return image
			imagejpeg($thumb,$image_thumb);

			// Destroy
			imagedestroy($thumb);
		}

		// Return the thumbnail
		return site_url($image_thumb);
	}
	else
	{
		// return 'http://placehold.it/'.$width.'x'.$height;
		return site_url('img/geen-foto.png');
	}
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */