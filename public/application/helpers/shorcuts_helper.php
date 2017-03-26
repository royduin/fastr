<?php
function site_name()
{
	return config_item('website_name');
}

function site_descr()
{
	return config_item('website_description');
}

function e($string)
{
	return html_escape($string);
}

function logged_in()
{
	$CI =& get_instance();
	return $CI->session->userdata('username') ? TRUE : FALSE;
}

function user($item = FALSE)
{
	$CI =& get_instance();
	if($item)
	{
		return isset($CI->session->all_userdata()[$item]) ? $CI->session->all_userdata()[$item] : FALSE;
	}
	return $CI->session->all_userdata();
}

function max_length($string,$length)
{
	return (strlen($string) > $length) ? substr($string, 0, $length) . '...' : $string;
}

function remove_dir($dirPath)
{
	// Valid directory?
	if(is_dir($dirPath))
	{
		// No slash at the end?
		if(substr($dirPath, strlen($dirPath) - 1, 1) != '/')
		{
			// Add slash
			$dirPath .= '/';
		}

		// Get all files in directory
		$files = glob($dirPath . '*', GLOB_MARK);

		// Foreach file
		foreach ($files as $file)
		{
			// Directory?
			if (is_dir($file))
			{
				// Remove directory
				remove_dir($file);
			}
			else
			{
				// Remove file
				unlink($file);
			}
		}

		// Remove directory
		rmdir($dirPath);	
	}
}

function age($birthday)
{
	list($year,$month,$day) = explode("-",$birthday);
	$year_diff  = date("Y") - $year;
	$month_diff = date("m") - $month;
	$day_diff   = date("d") - $day;
	if ($month_diff < 0) $year_diff--;
	elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
	return $year_diff;
}

function remove_empty_lines($string)
{
	return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
}