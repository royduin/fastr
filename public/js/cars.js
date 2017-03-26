(function()
{
	// Brand change?
	$('#brand').change(function()
	{
		// Hide everything
		$('#model').val(0);
		$('#type').val(0);
		$('#model-select').slideUp();
		$('#type-select').slideUp();

		// Clear possible previous results
		$('#model').html('<option value="">Alle modellen</option>');
		$('#type').html('<option value="">Alle uitvoeringen</option>');

		// Set credentials
		var select 	= $(this);
		var name 	= select.find(':selected').text();
		var val 	= select.val();

		// ID set?
		if(val != 0)
		{
			// Get with Ajax
			$.ajax({
				url: 'http://fastr.nl/ajax/models',
				type: 'post',
				data: {
					csrf_fastr: $("input[name=csrf_fastr]").val(),
					brand: name
				},
				dataType: 'json',
				success: function (data)
				{
					// Foreach model
					$.each(data,function(key,value)
					{
						// Add options
						$('#model').append($("<option></option>").attr("value",value).text(value));
					});

					// First run?
					if(first_run === true)
					{
						// Get model form url
						var current_model = $.url().param('model');

						// Model set?
						if( current_model )
						{
							// Selected the current model
							$('#model option[value="'+current_model+'"]').attr('selected','selected');

							// Go to the types!
							$('#model').change();
						}
					}

					$('#model-select').slideDown();
				}
			});
		}
	});

	// Model change?
	$('#model').change(function()
	{
		// Hide everything
		$('#type').val(0);
		$('#type-select').slideUp();

		// Clear possible previous results
		$('#type').html('<option value="">Alle uitvoeringen</option>');

		// Set credentials
		var select 	= $(this);
		var name 	= select.find(':selected').text();
		var val 	= select.val();

		// ID set?
		if(val != 0)
		{
			// Clear possible previous results
			$('#type').html('<option value="">Alle uitvoeringen</option>');

			// Get with Ajax
			$.ajax({
				url: 'http://fastr.nl/ajax/types',
				type: 'post',
				data: {
					csrf_fastr: $("input[name=csrf_fastr]").val(),
					brand: $('brand').val(),
					model: name
				},
				dataType: 'json',
				success: function (data)
				{
					// Foreach model
					$.each(data,function(key,value)
					{
						// Add options
						$('#type').append($("<option></option>").attr("value",value).text(value)); 
					});

					// First run?
					if(first_run === true)
					{
						// Get type form url
						var current_type = $.url().param('type');

						// Type set?
						if( current_type )
						{
							// Selected the current type
							$('#type option[value="'+current_type+'"]').attr('selected','selected');
						}
					}

					$('#type-select').slideDown();
				}
			});
		}
	});

	// Brand already set?
	if( $('#brand').val() != 0 )
	{
		// Set first run
		var first_run = true;

		// Run brand change
		$('#brand').change();
	}

})();