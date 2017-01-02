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
			$('form .field').removeClass("error");
			$('html').addClass('form-submit-success');

			// scroll to bottom of page and
			$('html, body').stop(true).animate({
				scrollTop: $(document).height() - $(window).height()
            }, 500, 'easeOutQuint');
		} else {
			$('form .field').removeClass("error");
			$.each(data.errors, function(index, error) {
				var $field = $form.find('[name=' + index + ']');
				$field.attr("placeholder", error);
				$field.closest('.field').addClass('error');
			});

			$('html, body').stop(true).animate({
				scrollTop: $form.find('.error:first').offset().top - $('#header').height() - 25
			}, 500, 'easeOutQuint');
		}
	}).fail(function (data) {
console.log(data);
		// Scroll to first error
		$('html, body').stop(true).animate({
			scrollTop: $form.find('.error:first').offset().top - $('#header').height() - 25
		}, 500, 'easeOutQuint');
	}).always(function () {
		// Enable submit
		$submit.prop('disabled', false);
	});
});
