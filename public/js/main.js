(function()
{
	// Tooltips
	$('.tip').tooltip();

	// Auto resize textarea's
	$('textarea').autosize({append: "\n"});

	// Confirm message
	$('.confirm').click(function()
	{
		return confirm('Zeker weten?');
	});

	// Thumbnail rows fix for browsers who don't support CSS3's nth-child
	$('.row-fluid ul.thumbnails li.span3:nth-child(4n + 5)').css('margin-left','0px');
	$('.row-fluid ul.thumbnails li.span2:nth-child(6n + 7)').css('margin-left','0px');

	// Fancybox
	$('.fancybox').fancybox({
		padding: 0
	});

	// Nivo slider
	$('#slider').nivoSlider({
		pauseOnHover: false,
		animSpeed: 750,
		pauseTime: 5000,
		directionNav: false,
		controlNav: false,
		randomStart: true
	});

	// Fit text
	$('.fittext').fitText();

	// Edit comment
	$('.edit-comment').click(function()
	{
		// Set variables
		var a 		= $(this);
		var p 		= a.parent().next().next();
		var id 		= a.data('id');
		var comment = p.html().replace(/<br>/g, '');

		// Hide all edit buttons
		$('.edit-comment').hide();

		// Hide paragraph and add a textarea with buttons
		p.hide().after('<div class="btn-group pull-right"><a href="javascript:location.reload();" class="btn btn-danger">Annuleren</a><a href="#" class="btn btn-primary edit-comment-submit" data-id="'+id+'">Bewerken</a></div>')
				.after('<textarea id="edit-comment-textarea">'+comment+'</textarea>');

		// Autosize the textarea
		$('textarea').autosize({append: "\n"});

		// Return false to disable the anchor
		return false;
	});

	// Edit comment submit
	$('body').on('click','.edit-comment-submit',function(e)
	{
		// Set variables
		var button 	= $(this);
		var id 		= button.data('id');
		var comment = button.parent().prev().val();

		// Send to the server
		$.ajax({
			url: 'http://fastr.nl/ajax/comment',
			type: 'post',
			data: {
				csrf_fastr: $("input[name=csrf_fastr]").val(),
				id: 		id,
				comment: 	comment
			},
			dataType: 'json',
			success: function (data)
			{
				location.reload();
			},
			error: function()
			{
				alert('Er ging iets fout! Probeer het later opnieuw of je hebt niets ingevuld')
			}
		});

		// Return false to disable the anchor
		return false;
	});

})();