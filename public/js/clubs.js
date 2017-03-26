(function()
{
	// Checkbox changed?
	$('#open').change(function()
	{
		// Checked?
		if( $(this).is(":checked") )
		{
			// Show
			$('#members-check').slideUp();
		}
		else
		{
			// Hide
			$('#members-check').slideDown();
		}
	});
})();