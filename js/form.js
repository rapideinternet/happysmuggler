var $form = $('#contact form');

// Form submission
$form.submit(function(e) {
	e.preventDefault();
    var actionurl = $(this).attr('action');
	var $submit = $form.find("[type='submit']");

	// Disable submit
	$submit.prop('disabled', true);

	// remove success class from html element
	$('html').removeClass('form-submit-success');

	// Submit the form
	$.ajax({
		url: actionurl,
		type: 'post',
		dataType: 'json',
		data: $form.serialize()
	}).done(function (data) {
		// set success class to html element
		if(data.success === true) {
			$form.replaceWith("<div style=\"text-align: center\"><h3 style=\"font-size: 1.2em; letter-spacing: .1em;\">You Rock! Thanks for your message!</h3></div>");
			$('form .field').removeClass("error");
			$('html').addClass('form-submit-success');
		} else {
			$('form .field').removeClass("error");
			$.each(data.errors, function(index, error) {
				var $field = $form.find('[name=' + index + ']');
				$field.attr("placeholder", error);
				$field.closest('.field').addClass('error');
			});

			$('html, body').stop(true).animate({
				scrollTop: $form.find('.error:first').offset().top - $('#header').height() - 25
			}, 500);
		}
	}).fail(function (data) {
		// Scroll to first error
		$('html, body').stop(true).animate({
			scrollTop: $form.find('.error:first').offset().top - $('#header').height() - 25
		}, 500);
	}).always(function () {
		// Enable submit
		$submit.prop('disabled', false);
	});
});
