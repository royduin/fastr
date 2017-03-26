<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Only changed the lowercase to be default TRUE
function url_title($str, $separator = '-', $lowercase = TRUE)
{
	if ($separator == 'dash') 
	{
	    $separator = '-';
	}
	else if ($separator == 'underscore')
	{
	    $separator = '_';
	}
	
	$q_separator = preg_quote($separator);

	$trans = array(
		'&.+?;'                 => '',
		'[^a-z0-9 _-]'          => '',
		'\s+'                   => $separator,
		'('.$q_separator.')+'   => $separator
	);

	$str = strip_tags($str);

	foreach ($trans as $key => $val)
	{
		$str = preg_replace("#".$key."#i", $val, $str);
	}

	if ($lowercase === TRUE)
	{
		$str = strtolower($str);
	}

	return trim($str, $separator);
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */