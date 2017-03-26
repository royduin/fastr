<?php
function specs($specs)
{
	// Categories present?
	if(strstr($specs,'**') !== FALSE)
	{
		// Explode by categorie
		$categories = explode('**',$specs);
		$cat_amount = count($categories) - 1;

		// Remove first empty one
		unset($categories[0]);

		// Foreach categorie
		foreach($categories as $cat=>$categorie)
		{
			// Explode by lines
			$lines 		= explode("\n",$categorie);

			// Does have multiple lines and it's not the last one?
			if(count($lines) > 0 AND $cat != $cat_amount)
			{
				// Remove last empty one
				array_pop($lines);
			}
			
			// Count total lines
			$amount 	= count($lines) - 1;

			// Add headings and open unordered-list
			$lines[0] 	= '<h4>'.$lines[0].'</h4><ul>';

			// Foreach line
			foreach($lines as $num=>$line)
			{
				// Make list-items but not the first one
				if($num != 0)
				{
					$lines[$num] = '<li>'.$lines[$num].'</li>';
				}

				// Last item?
				if($num == $amount)
				{
					// Close unordered-list
					$lines[$num] = $lines[$num].'</ul>';
				}
			}

			// Implode it back to the categories
			$categories[$cat] = implode('',$lines);
		}

		// Columns
		$col[] = implode('',array_slice($categories,0,ceil($cat_amount / 2)));
		$col[] = implode('',array_slice($categories,ceil($cat_amount / 2)));
	}
	else
	{
		// Explode by lines
		$lines 	= explode("\n",$specs);
		$amount = count($lines);

		// Just one line?
		if($amount == 1)
		{
			// Set one column
			$col[] = $lines[0];
		}
		else
		{
			// Columns
			$col[] = '<ul><li>'.implode('</li><li>',array_slice($lines,0,ceil($amount / 2))).'</li></ul>';
			$col[] = '<ul><li>'.implode('</li><li>',array_slice($lines,ceil($amount / 2))).'</li></ul>';
		}
	}

	// Return it!
	return '<div class="row-fluid"><div class="span6">'.implode('</div><div class="span6">',$col).'</div></div>';
}