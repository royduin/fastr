(function()
{
	// Brand
	$('#brand').typeahead({
		minLength: 0,
		items: 9999,
		source: function(query,process)
		{
			return $.ajax({
				url: 'http://fastr.nl/ajax/brands',
				type: 'post',
				data: { 
					query: query,
					csrf_fastr: $("input[name=csrf_fastr]").val() 
				},
				dataType: 'json',
				success: function (data){
					return process(data)
				}
			});
		}
	});
	$("#brand").on('focus', $("#brand").typeahead.bind($("#brand"), 'lookup'));

	// Model
	$('#model').typeahead({
		minLength: 0,
		items: 9999,
		source: function(query,process)
		{
			return $.ajax({
				url: 'http://fastr.nl/ajax/models',
				type: 'post',
				data: { 
					query: query,
					csrf_fastr: $("input[name=csrf_fastr]").val(),
					brand: $('#brand').val()
				},
				dataType: 'json',
				success: function (data){
					return process(data)
				}
			});
		}
	});
	$("#model").on('focus', $("#model").typeahead.bind($("#model"), 'lookup'));

	// Type
	$('#type').typeahead({
		minLength: 0,
		items: 9999,
		source: function(query,process)
		{
			return $.ajax({
				url: 'http://fastr.nl/ajax/types',
				type: 'post',
				data: { 
					query: query,
					csrf_fastr: $("input[name=csrf_fastr]").val(),
					brand: $('#brand').val(),
					model: $('#model').val()
				},
				dataType: 'json',
				success: function (data){
					return process(data)
				}
			});
		}
	});
	$("#type").on('focus', $("#type").typeahead.bind($("#type"), 'lookup'));


})();